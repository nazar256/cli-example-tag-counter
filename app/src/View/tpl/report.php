<?php
use View\ReportView;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tag count report</title>
    <style type="text/css">
        table, th, td {
            border: 1px solid;
        }
    </style>
</head>

<body>
<table>
    <thead>
    <tr>
        <th>Page URL</th>
        <th><?= $tagName ?> tag count</th>
        <th>Page process time (sec)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stats as $statsRow) { ?>
        <tr>
            <td><?= htmlentities($statsRow[ReportView::KEY_URL]) ?></td>
            <td><?= htmlentities($statsRow[ReportView::KEY_TAG_COUNT]) ?></td>
            <td><?= htmlentities($statsRow[ReportView::KEY_PROCESS_TIME]) ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>