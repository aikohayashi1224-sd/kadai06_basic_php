<?php
// CSVファイルを開く
$file = fopen('data.csv', 'r');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>フィードバック一覧</title>
</head>
<body>
    <h1>フィードバック一覧</h1>
    <table border="1">
        <tr>
            <th>日時</th><th>発表者</th><th>ビジネスモデル</th><th>プレゼン</th><th>総合点</th><th>コメント</th>
        </tr>
        <?php
        // 1行ずつ読み込む
        while (($row = fgetcsv($file)) !== FALSE) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "</tr>";
        }
        fclose($file);
        ?>
    </table>
    <br>
    <a href="index.php">入力画面に戻る</a>
</body>
</html>