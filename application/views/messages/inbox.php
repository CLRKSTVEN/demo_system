<h2>Inbox</h2>
<?php foreach ($messages as $msg): ?>
    <div>
        <strong>From:</strong> <?= $msg->sender_id ?><br>
        <strong>Subject:</strong> <?= $msg->subject ?><br>
        <p><?= $msg->body ?></p>
        <small><?= $msg->created_at ?></small>
        <hr>
    </div>
<?php endforeach; ?>