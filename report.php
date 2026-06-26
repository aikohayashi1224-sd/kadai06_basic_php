<?php
$presenters = ['ねこ', 'とら', 'ひょう', 'ちーたー', 'らいおん'];
$selected = $_GET['presenter'] ?? '';

$labels = ['最高', 'とてもよい', 'よい', 'まずまず'];
$counts = [
    'biz'   => array_fill_keys($labels, 0),
    'pres'  => array_fill_keys($labels, 0),
    'total' => array_fill_keys($labels, 0)
];
$comments = [];

if ($selected && file_exists('data.csv')) {
    if (($handle = fopen("data.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            // 列数チェック（入力者,日時,発表者,ビジネスモデル,プレゼン,総合点,コメント の7列）
            if (count($data) < 7) continue;

            // $data[2] が発表者
            if ($data[2] == $selected) {
                if (isset($counts['biz'][$data[3]]))   $counts['biz'][$data[3]]++;
                if (isset($counts['pres'][$data[4]]))  $counts['pres'][$data[4]]++;
                if (isset($counts['total'][$data[5]])) $counts['total'][$data[5]]++;
                if (!empty($data[6])) $comments[] = $data[6];
            }
        }
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>分析シート - かべうちプチ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #e0f7fa; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { color: #0277bd; text-align: center; font-size: 24px; margin-bottom: 20px; }
        .selector { text-align: center; margin-bottom: 30px; }
        select { padding: 12px; border-radius: 10px; border: 2px solid #b3e5fc; width: 100%; max-width: 300px; font-size: 16px; }
        
        .charts-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .chart-box { width: 100%; max-width: 250px; text-align: center; }
        
        /* 1か所にまとめた凡例のデザイン */
        .legend-container { display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; margin-top: 20px; font-size: 14px; }
        .legend-item { display: flex; align-items: center; }
        .legend-item span { width: 12px; height: 12px; margin-right: 5px; border-radius: 2px; }

        .comment-section { margin-top: 40px; border-top: 2px solid #eee; padding-top: 20px; }
        .comment-card { background: #f0f9ff; padding: 15px; border-radius: 10px; margin-bottom: 10px; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <h1>分析シート 📈</h1>
    <div class="selector">
        <form method="GET">
            <select name="presenter" onchange="this.form.submit()">
                <option value="">発表者を選択してください</option>
                <?php foreach($presenters as $name): ?>
                    <option value="<?=$name?>" <?=$selected==$name?'selected':''?>><?=$name?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <?php if ($selected): ?>
        <h2 style="text-align: center; color: #0277bd;"><?= htmlspecialchars($selected) ?> さん</h2>
        
        <div class="charts-container">
            <?php 
            $items = ['biz' => 'ビジネスモデル', 'pres' => 'プレゼン', 'total' => '総合点'];
            foreach ($items as $key => $label): ?>
                <div class="chart-box">
                    <p style="font-weight: bold; margin-bottom: 10px;"><?= $label ?></p>
                    <canvas id="chart-<?= $key ?>"></canvas>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="legend-container">
            <div class="legend-item"><span style="background: #ff5252;"></span>最高</div>
            <div class="legend-item"><span style="background: #4fc3f7;"></span>とてもよい</div>
            <div class="legend-item"><span style="background: #aed581;"></span>よい</div>
            <div class="legend-item"><span style="background: #ffd54f;"></span>まずまず</div>
        </div>

        <div class="comment-section">
            <h3>コメント 💬</h3>
            <?php if (empty($comments)): ?>
                <p style="text-align: center; color: #999;">まだコメントがありません。</p>
            <?php else: ?>
                <?php foreach(array_reverse($comments) as $c): ?>
                    <div class="comment-card"><?= nl2br(htmlspecialchars($c)) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <script>
            function createChart(id, dataValues) {
                const ctx = document.getElementById(id).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['最高', 'とてもよい', 'よい', 'まずまず'],
                        datasets: [{
                            data: dataValues,
                            backgroundColor: ['#ff5252', '#4fc3f7', '#aed581', '#ffd54f']
                        }]
                    },
                    options: { plugins: { legend: { display: false } } } // 個別の凡例は非表示
                });
            }
            createChart('chart-biz',   <?= json_encode(array_values($counts['biz'])) ?>);
            createChart('chart-pres',  <?= json_encode(array_values($counts['pres'])) ?>);
            createChart('chart-total', <?= json_encode(array_values($counts['total'])) ?>);
        </script>
    <?php endif; ?>
    
    <p style="text-align: center; margin-top: 30px;"><a href="index.php" style="color: #0277bd; text-decoration: none;">← 入力画面に戻る</a></p>
</div>

</body>
</html>