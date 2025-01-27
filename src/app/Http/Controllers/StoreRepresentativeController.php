<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StoreRepresentativeController extends Controller
{
    public function register(Request $request)
    {
        $dir = 'image';
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        $user_id = Auth::id();
        $input = Shop::create([
            'user_id' => $user_id,
            'shop_name' => $request->shop_name,
            'area_id' => $request->area,
            'genre_id' => $request->genre,
            'overview' => $request->overview,
            'file_name' => $file_name,
            'file_path' => 'storage/' . $dir . '/' . $file_name,
        ]);

        return redirect('/');
    }

    public function csvImport(Request $request)
    {
        $user_id = Auth::id();

        if($request->hasFile('csv') && $request->file('csv')->isValid()) {
            // CSVファイル保存
            $tmp_name = uniqid("CSVUP_").".".$request->file('csv')->guessExtension();
            $request->file('csv')->move(public_path()."/csv/tmp",$tmp_name);
            $tmp_path = public_path()."/csv/tmp/".$tmp_name;
            // Goodby CSVの設定
            $config_in = new LexerConfig();
            $config_in
                ->setToCharset("UTF-8") //CharsetをUTF-8に変換
                ->setIgnoreHeaderLine(true); //CSVのヘッダーを無視

            $lexer_in = new Lexer($config_in);

            $datalist = array();

            $interpreter = new Interpreter();
            $interpreter->addObserver(function (array $row) use (&$datalist){
                // 各列のデータを取得
                $datalist[] = $row;
            });

            // CSVデータをパース
            $lexer_in->parse($tmp_path,$interpreter);

            // TMPファイル削除
            unlink($tmp_path);

            $validationMessages = [];

            //処理
            foreach($datalist as $row) {
                // 各データ取り出し
                $csv_shop = $this->get_csv_shop($row);

                 // 画像URLから拡張子を取得
                $extension = pathinfo($csv_shop['picture_url'], PATHINFO_EXTENSION);

                // 画像URLの拡張子がjpegかpngでない場合はエラー
                if (!in_array($extension, ['jpeg', 'jpg', 'png'])) {
                    $validationMessages[] = ['picture_url' => '画像の形式はjpeg(jpg)かpngのみとなります。'];
                    continue;
                }

                $validator = Validator::make($csv_shop, [
                    'shop_name' => 'required|max:50',
                    'area_id' => 'required|in:1,2,3',
                    'genre_id' => 'required|in:1,2,3,4,5',
                    'overview' => 'required|max:400',
                ], [
                    'required' => '※入力していない項目があります。',
                    'shop_name.max' => '※店舗名は50文字以内で入力してください。',
                    'area_id.in' => '※地域は東京都・大阪府・福岡県のいずれかで登録してください。',
                    'genre_id.in' => '※ジャンルは寿司・焼肉・イタリアン・居酒屋・ラーメンのいずれかで登録してください。',
                    'overview.max' => '※店舗概要は400文字以内で入力してください。',
                ]);

                if ($validator->fails()) {
                    $validationMessages[] = $validator->errors()->all();
                } else {
                    // user_idを追加
                    $csv_shop['user_id'] = $user_id;

                    // DBへの登録
                    $this->register_shop_csv($csv_shop);
                }
            }

            if (!empty($validationMessages)) {
                return redirect('/')->with('validation_errors', $validationMessages);
            }

            return redirect('/')->with('message','CSVのデータを読み込みました。');
        } else {
            return redirect('/')->with('message','登録に失敗しました。');
        }
    }

    private function get_csv_shop($row)
    {
        $shop = array(
            'shop_name' => $row[1],
            'area_id' => Shop::getAreaIdByName($row[2]),
            'genre_id' => Shop::getGenreIdByName($row[3]),
            'overview' => $row[4],
            'picture_url' => $row[5],
        );

        return $shop;
    }

    private function register_shop_csv($csv_shop)
    {
        $new_shop = new Shop();
        $new_shop->user_id = $csv_shop['user_id'];
        $new_shop->shop_name = $csv_shop['shop_name'];
        $new_shop->area_id = $csv_shop['area_id'];
        $new_shop->genre_id = $csv_shop['genre_id'];
        $new_shop->overview = $csv_shop['overview'];
        $new_shop->picture_url = $csv_shop['picture_url'];

        $new_shop->save();
    }


    public function reservationCheck()
    {
        $user_id = Auth::id();
        $shop = Shop::where('user_id', $user_id)->first();
        $shop_name = $shop->shop_name;
        $reservations = Reservation::where('shop_id', $shop->id)->orderBy('reservation_date', 'asc')->paginate(10);

        return view('reservation_check', compact('shop_name', 'reservations'));
    }

    public function downloadCsv()
    {
        $users = User::all();
        $csvHeader = ['id', 'name', 'email', 'created_at', 'updated_at'];
        $csvData = $users->toArray();

        $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);

            foreach ($csvData as $row) {
            fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'content-Disposition' => 'attachment; filename="users.csv"',
        ]);

        return $response;
    }
}
