# 在庫管理アプリ（Inventory Management App）

Laravelを使用して開発した、備品の在庫管理を行うWebアプリケーションです。  
管理者と一般ユーザーで操作権限を分け、備品の登録・検索・管理を効率化できるよう設計しています。

---

## 🔗 デモ

※ローカル環境で動作（Docker）

---

## 🧩 主な機能

### ■ 認証・権限管理
- ログイン / ログアウト（Laravel Breeze）
- 管理者 / 一般ユーザーのロール管理
- Policyによる権限制御
  - 管理者：作成・編集・削除可能
  - 一般ユーザー：閲覧のみ

---

### ■ 備品管理
- 備品CRUD（作成・一覧・詳細・編集・削除）
- カテゴリーとの紐付け
- 在庫数管理
- ステータス管理（在庫あり / 在庫切れ / 廃番）
- 在庫数に応じたステータス自動制御

---

### ■ カテゴリー管理
- カテゴリーCRUD
- 備品が紐づいている場合は削除不可（制約あり）

---

### ■ 検索・絞り込み
- キーワード検索（備品名 / コード / 保管場所）
- カテゴリー絞り込み
- ページネーション対応

---

### ■ CSV出力
- 検索・絞り込み結果をそのままCSV出力
- Excel文字化け対策（BOM付き）

---

### ■ ダッシュボード
- 総備品数
- 在庫あり / 在庫切れ / 廃番の件数
- カテゴリー数
- 最近追加された備品一覧

---

## 🛠 技術スタック

- PHP（Laravel）
- MySQL
- Docker / Docker Compose
- Tailwind CSS
- Vite

---

## 📦 環境構築方法

```bash
git clone https://github.com/ryuunosuke-1113/inventory-management-app
cd inventory-manager

docker compose up -d --build

docker compose exec php composer install
docker compose exec php cp .env.example .env
docker compose exec php php artisan key:generate

docker compose exec php php artisan migrate --seed

docker compose exec php npm install
docker compose exec php npm run build
```
## 🔑 テスト用アカウント

| 種別 | メール | パスワード |
|------|--------|-----------|
| 管理者 | admin@example.com | password |
| 一般ユーザー | user@example.com | password |
## 📸 スクリーンショット

（ここに画像）

## 💡 工夫した点
- Policyを用いた権限制御により、安全な操作制限を実現
- 検索条件を維持したままCSV出力できるよう設計
- 在庫数とステータスの整合性を自動制御
- カテゴリー削除時の整合性（外部キー制約 + バリデーション）を考慮
- UIをTailwindで統一し、視認性を向上
## 🔥 今後の改善案
- 在庫の入出庫履歴管理
- CSVインポート機能
- グラフ表示（Chart.js）
- API化