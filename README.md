了解！
じゃあ**より「自作アプリのREADMEっぽく」**、テンションをちょっと砕けた表現にして書き直すね👇

---

# 📨 お問い合わせ管理アプリ（Laravel練習用）

Renderにデプロイ済みのLaravel製お問い合わせ管理アプリです。
基本的なCRUDから検索・並び替え・CSVダウンロードまで、Laravelでよく使う機能を一通り入れてます。

📎 **デモURL**
🔗 [https://udemy-laravel-basic.onrender.com/contacts](https://udemy-laravel-basic.onrender.com/contacts)

---

## 🛠 使用技術

| 項目      | 内容                       |
| ------- | ------------------------ |
| フレームワーク | Laravel 9.19             |
| 言語      | PHP 8.2（Render環境）        |
| DB      | MySQL（Renderで外部接続）      |
| 認証      | Laravel Breeze           |
| テンプレート  | Blade                    |
| 本番環境    | Docker + Render（無料プラン）   |
| ローカル    | MAMP / Composer / VSCode |

---

## ✅ 実装した主な機能

* ログイン・ログアウト（Breeze使用）
* お問い合わせ一覧／新規登録／編集／削除
* 氏名・メール・内容でAND検索（複数ワードOK）
* 各項目ごとに昇順／降順の並び替え
* アクセサでメールの@前だけを一覧表示
* CSV出力（検索・ソート状態を反映）
* Featureテスト（Store機能のみ）

---

## 🧪 テスト用アカウント

```
Email: test@example.com
Password: password123
```

---

## 🧱 ローカル開発用セットアップ

```bash
git clone https://github.com/tojiinoue/udemy_laravel_basic.git
cd udemy_laravel_basic

# PHP系
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# フロント系（CSS反映に必要）
npm install
npm run build

php artisan serve
# → http://localhost:8000 にアクセス
```

---

## 🔧 今後の改修予定

* ソフトデリート（論理削除）対応
* 管理者ロールによるアクセス制御
* スケジュールバッチ処理の追加
* CSVインポート機能

---

## 📝 補足（本番環境の課題）

* CSSはViteでビルド → `public/build` を Git に含める必要あり
* `.env` の `APP_URL` は必ず `https://` に設定
* CSRFが原因でフォーム送信時に「安全でない」と出る → `URL::forceScheme('https')` で対応
* CSVダウンロードは `response()->streamDownload()` で実装済み（Renderでも動作確認済み）
