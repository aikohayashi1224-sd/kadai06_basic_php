<?php
// 1. 設定ファイルを読み込む
require_once('config.php'); 

session_start();

// 2. 認証処理
if (isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "パスワードが違います";
    }
}

// 3. 認証されていない場合はログイン画面を表示
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true):
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding-top: 50px; background: #e0f7fa; }
        .login-box { background: white; padding: 30px; display: inline-block; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>管理者ログイン</h1>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="password" name="password" required>
            <button type="submit">ログイン</button>
        </form>
    </div>
</body>
</html>
<?php 
    exit; // ここから先は表示させない
endif;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者専用画面</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>全データ閲覧（管理者用）</h1>
    <table>
        <tr>
            <th>入力者</th>
            <th>タイムスタンプ</th>
            <th>発表者</th>
            <th>ビジネスモデル</th>
            <th>プレゼン</th>
            <th>総合点</th>
            <th>コメント</th>
        </tr>
        <?php
        $file = fopen('data.csv', 'r');
        while (($row = fgetcsv($file)) !== FALSE) {
            // 空行エラー回避のため、最低限の列があるか確認
            if (count($row) < 7) continue; 
            
            echo "<tr>";
            // 配列の順番通りに表示します
            echo "<td>" . htmlspecialchars($row[0]) . "</td>"; // 入力者ID
            echo "<td>" . htmlspecialchars($row[1]) . "</td>"; // タイムスタンプ
            echo "<td>" . htmlspecialchars($row[2]) . "</td>"; // 発表者
            echo "<td>" . htmlspecialchars($row[3]) . "</td>"; // ビジネスモデル
            echo "<td>" . htmlspecialchars($row[4]) . "</td>"; // プレゼン
            echo "<td>" . htmlspecialchars($row[5]) . "</td>"; // 総合点
            echo "<td>" . htmlspecialchars($row[6]) . "</td>"; // コメント
            echo "</tr>";
        }
        fclose($file);
        ?>
    </table>
</body>
</html>