## 概要
**Hyperf**のサンプルプロジェクトです。

## 環境構築
このプロジェクトでは、``docker-compose``がインストールされていることが前提です。

### PHPパッケージインストール
```bash
docker compose run --rm composer install
```

### アプリサーバー起動
```bash
docker compose up -d hyperf-app

# http://localhost:9501 にアクセスできればOK！
```

### マイグレーション
```bash
docker compose exec hyperf-app php bin/hyperf.php migrate

# http://localhost:9501/user にアクセスできればOK！
```

### テスト
```bash
docker compose exec hyperf-app composer test
```
