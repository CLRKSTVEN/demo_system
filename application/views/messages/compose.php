<h2>Compose Message</h2>
<form method="post" action="<?= site_url('messages/send') ?>">
    <label>To:</label>
    <!-- <select name="receiver_id" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->username ?>"><?= $user->position ?> - <?= $user->fName ?> <?= $user->lName ?></option>
        <?php endforeach; ?>
    </select><br> -->

    <input type="text" value="98765432223" name="receiver_id">

    <label>Subject:</label>
    <input type="text" name="subject" required><br>

    <label>Message:</label>
    <textarea name="body" required></textarea><br>

    <button type="submit">Send</button>
</form>