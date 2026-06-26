<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>かべうちプチ - フィードバック</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #e0f7fa; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #ffffff; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { color: #0277bd; text-align: center; font-size: 24px; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; }
        
        label { display: block; margin-top: 15px; font-weight: bold; color: #0277bd; }
        select, textarea, input[type="text"] { 
    width: 100%; 
    padding: 12px; 
    margin-top: 5px; 
    border: 2px solid #b3e5fc; 
    border-radius: 10px; 
    box-sizing: border-box; 
}
        
        .radio-group { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
        .radio-group label { margin-top: 0; font-weight: normal; background: #f0f9ff; padding: 8px 12px; border-radius: 20px; font-size: 14px; cursor: pointer; border: 1px solid #b3e5fc; }
        input[type="radio"]:checked + span { color: #ff5252; font-weight: bold; }
        
        button { width: 100%; background-color: #ff5252; color: white; border: none; padding: 15px; border-radius: 10px; font-size: 18px; margin-top: 30px; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #ff1744; }

        .report-link {
    display: inline-block;
    padding: 12px 20px;
    background-color: #0277bd; /* 青色ベース */
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-size: 16px;
    transition: 0.3s;
}

.report-link:hover {
    background-color: #01579b; /* ホバー時に少し濃い青へ */
}

    </style>
</head>
<body>

<div class="container">
    <h1 style="color: #0277bd; font-family: 'Arial', sans-serif; text-align: center; margin-bottom: 20px;">
        <span style="font-size: 0.8em; color: #ff5252;">💬</span> かべうちプチ<span style="font-size: 0.8em; color: #ff5252;">💬</span> 
    </h1>
    <p class="subtitle">フィードバック入力フォーム</p>

    <form action="save.php" method="POST">

    <label>あなた：</label>
        <input type="text" name="user_id" placeholder="名前を入力" required>

    <label>発表者：</label>
        <select name="presenter" required>
            <option value="">選択してください</option>
            <option value="ねこ">ねこ</option>
            <option value="とら">とら</option>
            <option value="ひょう">ひょう</option>
            <option value="ちーたー">ちーたー</option>
            <option value="らいおん">らいおん</option>
        </select>

        <?php foreach(['ビジネスモデル', 'プレゼンテーション', '総合点'] as $item): ?>
            <label><?php echo $item; ?></label>
            <div class="radio-group">
                <?php foreach(['最高', 'とてもよい', 'よい', 'まずまず'] as $val): ?>
                    <label><input type="radio" name="evaluation[<?php echo $item; ?>]" value="<?php echo $val; ?>" required> <span><?php echo $val; ?></span></label>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <label>コメント（自由入力）：</label>
        <textarea name="comment" rows="4" placeholder="このアイディアのここが良かったです！" required></textarea>

        <button type="submit">フィードバックを送信</button>
    </form>

<div style="text-align: center; margin-top: 30px;">
    <a href="report.php" class="report-link">分析レポートを見る 📈</a>
</div>

</div>

</body>
</html>
