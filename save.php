<?php
// POSTされたデータがあるか確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSV保存処理はそのまま
    $presenter = $_POST['presenter'];
    $evaluation = $_POST['evaluation'];
    $comment = $_POST['comment'];
    $timestamp = date("Y-m-d H:i:s");

    $data = [
    $_POST['user_id'],   // 0: 入力者
    $timestamp,          // 1: タイムスタンプ
    $presenter,          // 2: 発表者
    $evaluation['ビジネスモデル'], // 3
    $evaluation['プレゼンテーション'], // 4
    $evaluation['総合点'], // 5
    $comment             // 6
    ];
    $file = fopen('data.csv', 'a');
    fputcsv($file, $data);
    fclose($file);
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了 - かべうちプチ</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #e0f7fa; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 50px auto; background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #0277bd; font-size: 24px; margin-bottom: 20px; }
        p { color: #666; margin-bottom: 30px; }
        .btn { display: inline-block; background-color: #0277bd; color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn:hover { background-color: #01579b; }
    </style>
</head>
<body>

<div class="container">
    <h1>送信完了しました！</h1>
    <p>貴重なフィードバックをありがとうございました。<br>発表者への大きな励みになります。</p>
    <a href="index.php" class="btn">続けて入力する</a>
</div>

</body>
</html>