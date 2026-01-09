# New Contact Form

このプロジェクトは、確認テストにおいて作成したお問い合わせフォームです。

## 環境構築

1. リポジトリをクローン
```bash
 git clone git@github.com:as0622as/new-contact-form.git
 cd new-contact-form/laravel

2. Dockerを起動
 docker compose up -d

3. 依存関係をインストール
 docker compose exec app composer install

4. 環境設定
 docker compose exec app cp .env.example .env
 docker compose exec app php artisan key:generate

5. データベースマイグレーション
 docker compose exec app php artisan migrate

6. ブラウザでアクセス
 http://localhost:8000

##　構成
    Laravel: バックエンド
    MySQL: データベース
    Nginx + PHP-FPM: Webサーバ
    Docker Compose: 開発環境管理

## ER図
laravel/new-contact-form.drawio.png


