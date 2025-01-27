# Rese
飲食店の予約サービスを提供するアプリケーション。

## UI画像
会員ホーム（店舗一覧）
![店舗一覧](shop_all.png)

## 作成の経緯
外部の飲食店予約サービスは手数料を取られる為、

経費削減のために自社で予約サービスを提供する。

## アプリケーションURL
### 本番環境

http://35.72.13.191/

### 開発環境

http://localhost

### phpmyadmin

http://localhost:8080

### mailhog

http://localhost:8025

## 機能一覧
・会員登録 ・メール認証 ・ログイン／ログアウト ・ユーザー情報取得

・バリデーション（会員登録時／ログイン時／予約時） ・レスポンシブデザイン（ブレイクポイント：768px、480px）

### ユーザー
・飲食店一覧取得／詳細取得 ・飲食店お気に入り追加／削除

・ユーザー飲食店お気に入り一覧取得 ・飲食店予約情報追加／変更／削除

・予約リマインダー ・QRコード表示 ・ユーザー飲食店予約情報取得 ・決済機能

・飲食店口コミ評価新規登録/編集/削除 ・エリア／ジャンル／店名検索

・店舗一覧並び替え

### 管理者
・店舗代表者登録 ・メール送信機能　・店舗口コミ一覧表示/口コミ削除

### 店舗代表者
・店舗代表者専用画面 ・予約状況確認　・店舗情報CSVインポート登録


## 使用技術（実行環境）
<img src="https://img.shields.io/badge/-Php-777BB4.svg?logo=php&style=plastic"> <img src="https://img.shields.io/badge/-Laravel-E74430.svg?logo=laravel&style=plastic"> <img src="https://img.shields.io/badge/-Javascript-F7DF1E.svg?logo=javascript&style=plastic"> <img src="https://img.shields.io/badge/-Linux-FCC624.svg?logo=linux&style=plastic"> <img src="https://img.shields.io/badge/-Mysql-4479A1.svg?logo=mysql&style=plastic"> <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=plastic">

## テーブル設計
![table_layout](https://github.com/hirokam/Rese_dev/assets/145309969/59d9dae1-860d-4502-bec0-0a2743c378af)

## ER図
![ER図](ER_drawing.png)

# 環境構築
## 言語・フレームワーク:バージョン
PHP -ver: 7.4.9

Laravel -ver: 8.83.27

Mysql -ver: 8.0.26

nginx -ver: 1.21.1

## コマンド
### GitHubリポジトリのクローン
※SSH用githubクローンリンク : git@github.com:hirokam/Rese_dev.git

1.クローン : git clone git@github.com:hirokam/Rese_dev.git

2.リポジトリの紐付け先変更 : git remote set-url #変更前のリンク #新しい紐付け先リンク

3.リポジトリの紐付け先の変更確認 : git remote -v

### dockerコンテナの生成と起動
1.dockerコンテナの生成と起動 : docker-compose up -d --build

### Laravelの環境構築
1.PHPコンテナのコマンド操作 : docker-compose exec php bash

2.composerのインストール : composer install

3.composerのバージョン確認 : composer -v

4.(.env)ファイルの作成 : cp .env.example .env ->環境変数を変更

5.APP_KEYの生成 : php artisan key:generate

6.マイグレーションの実行 : php artisan migrate

7.シーディングの実行 : php artisan db:seed

8.スケジュールの実行 : php artisan schedule:work

9.シンボリックリンクの実行 : php artisan storage:link

## 環境変数
APP_NAME=Rese

DB_HOST=mysql

DB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass

MAIL_FROM_ADDRESS=rese@test.com

### STRIPE用公開キーと秘密キー
STRIPE_KEY=#YourSTRIPE_KEY

STRIPE_SECRET=#YourSTRIPE_SECRET

## その他
### インポートするCSVデータの作成について

|ヘッダー|店舗名|エリア|ジャンル|店舗概要|画像URL|
|:----:|:----:|:----:|:----:|:----:|:----:|
|店舗情報|◯◯◯※1|◯◯◯※2|◯◯◯※3|◯◯◯※4|◯◯◯※5|
|店舗情報|◯◯◯※1|◯◯◯※2|◯◯◯※3|◯◯◯※4|◯◯◯※5|
|店舗情報|◯◯◯※1|◯◯◯※2|◯◯◯※3|◯◯◯※4|◯◯◯※5|
|店舗情報|・|・|・|・|・|・|
|店舗情報|・|・|・|・|・|・|
|店舗情報|・|・|・|・|・|・|

 ※ :ヘッダーはインポート時に無視されます。

 ※ :インポートした際に項目がずれてしまう為、カラム間に無記入(スペース)は空けないでください（下記NG例）。

[NG例]

|ヘッダー|無記入|店舗名|エリア|ジャンル|店舗概要|画像URL|
|:----:|:----:|:----:|:----:|:----:|:----:|:----:|
|店舗情報|無記入|◯◯◯※1|◯◯◯※2|◯◯◯※3|◯◯◯※4|◯◯◯※5|
|店舗情報|無記入|◯◯◯※1|◯◯◯※2|◯◯◯※3|◯◯◯※4|◯◯◯※5|

 ※ :項目は全て入力必須です。

 ※1:店舗名は50文字以内で入力してください。

 ※2:エリアは『東京都』『大阪府』『福岡県』のいずれかを『』なしで入力してください。

 ※3:ジャンルは『寿司』『焼肉』『イタリアン』『居酒屋』『ラーメン』のいずれかを『』なしで入力してください。

 ※4:店舗概要は400文字以内で入力してください。

 ※5:画像URLの形式はjpeg(jpg),pngのみアップロード可能です。

 ※ :画像を上記※5の条件以外の形式でアップロードしようとするとその他の項目にエラーがあった場合、エラーメッセージが表示されません。

### テストアカウント
前置きとして

※1.鈴木一郎（権限:admin）

※2.鈴木花子(権限:store)

※22.田中花子(権限:user)

権限とSeederデータの都合上記3アカウントでの確認を推奨します。

---

1.鈴木一郎

role　: admin

メールアドレス : 1.suzuki@example.com

パスワード:12345678

---

2.鈴木花子

role　: store

メールアドレス : h.suzuki@example.com

パスワード:12345678

---

3.鈴木次郎

role　: store

メールアドレス : 2.suzuki@example.com

パスワード:12345678

---

4.鈴木三郎

role　: store

メールアドレス : 3.suzuki@example.com

パスワード:12345678

---

5.鈴木四郎

role　: store

メールアドレス : 4.suzuki@example.com

パスワード:12345678

---

6.鈴木五郎

role　: store

メールアドレス : 5.suzuki@example.com

パスワード:12345678

---

7.鈴木六郎

role　: store

メールアドレス : 6.suzuki@example.com

パスワード:12345678

---

8.鈴木七郎

role　: store

メールアドレス : 7.suzuki@example.com

パスワード:12345678

---

9.鈴木八郎

role　: store

メールアドレス : 8.suzuki@example.com

パスワード:12345678

---

10.鈴木九郎

role　: store

メールアドレス : 9.suzuki@example.com

パスワード:12345678

---

11.鈴木十郎

role　: store

メールアドレス : 10.suzuki@example.com

パスワード:12345678

---

12.田中一郎

role　: store

メールアドレス : 1.tanaka@example.com

パスワード:12345678

---

13.田中次郎

role　: store

メールアドレス : 2.tanaka@example.com

パスワード:12345678

---

14.田中三郎

role　: store

メールアドレス : 3.tanaka@example.com

パスワード:12345678

---

15.田中四郎

role　: store

メールアドレス : 4.tanaka@example.com

パスワード:12345678

---

16.田中五郎

role　: store

メールアドレス : 5.tanaka@example.com

パスワード:12345678

---

17.田中六郎

role　: store

メールアドレス : 6.tanaka@example.com

パスワード:12345678

---

18.田中七郎

role　: store

メールアドレス : 7.tanaka@example.com

パスワード:12345678

---

19.田中八郎

role　: store

メールアドレス : 8.tanaka@example.com

パスワード:12345678

---

20.田中九郎

role　: store

メールアドレス : 9.tanaka@example.com

パスワード:12345678

---

21.田中十郎

role　: store

メールアドレス : 10.tanaka@example.com

パスワード:12345678

---

22.田中花子

role　: user

メールアドレス : h.tanaka@example.com

パスワード:12345678

---
