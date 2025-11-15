<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request()) exit("CLI only.\n");
        $this->load->database();
        date_default_timezone_set('Asia/Manila');
    }

    /**
     * Nightly demo reset to baseline SQL.
     * Usage: php index.php tools reset_demo
     *
     * LOCAL (Windows): targets DB 'demo_a'
     * CPANEL (Linux):  targets DB 'srmsportal_demo1'
     *
     * Baseline SQL file (both): application/backup/srmsportal_demo1.sql
     */
    public function reset_demo()
    {
        // --- Pick target DB by OS (no manual edits needed when you upload) ---
        $isWin   = (stripos(PHP_OS, 'WIN') === 0);
        $targetDb = $isWin ? 'demo_a' : 'srmsportal_demo1';  // <-- cPanel uses 'srmsportal_demo1'

        // If you want to hard-force on cPanel later, you can comment the line above and uncomment this:
        // $targetDb = 'srmsportal_demo1'; // <-- CPANEL TARGET

        $baselineSqlPath = FCPATH . 'application/backup/srmsportal_demo1.sql';

        // DB creds from CI config
        $host = $this->db->hostname ?: 'localhost';
        $port = $this->db->port ?: 3306;
        $user = $this->db->username;
        $pass = $this->db->password;

        // Safety: refuse if CI isn't pointing at the target database
        if (strcasecmp($this->db->database, $targetDb) !== 0) {
            echo "❌ Safety check: CI is connected to '{$this->db->database}', not '{$targetDb}'.\n";
            echo "   Update application/config/database.php to use '{$targetDb}' before running.\n";
            return;
        }

        if (!is_file($baselineSqlPath)) {
            echo "❌ Baseline SQL not found: {$baselineSqlPath}\n";
            return;
        }

        // Find mysql client
        $mysql = $this->guess_mysql_path();

        echo "[" . date('Y-m-d H:i:s') . "] Starting demo reset…\n";
        echo " DB target: {$targetDb}\n";
        echo " SQL file : {$baselineSqlPath}\n";

        // 1) Drop & recreate the database
        try {
            $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->exec("DROP DATABASE IF EXISTS `{$targetDb}`");
            $pdo->exec("CREATE DATABASE `{$targetDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            echo " ✓ Recreated database '{$targetDb}'.\n";
        } catch (Exception $e) {
            echo "❌ DB admin error: " . $e->getMessage() . "\n";
            return;
        }

        // 2) Import baseline (Windows vs *nix)
        $E = function ($s) {
            return escapeshellarg($s);
        };
        $mysqlPath = $E($mysql);
        $hostArg   = " -h " . $E($host) . " -P " . (int)$port . " -u " . $E($user) . " ";

        if ($isWin) {
            // Windows: use -p"password" if set (omit -p entirely if blank)
            $passArg = strlen($pass) ? ' -p' . $E($pass) : '';
            $cmd = $mysqlPath . $hostArg . $passArg . " " . $E($targetDb) . " < " . $E($baselineSqlPath);
        } else {
            // Linux/cPanel: use env var so the password isn’t in process args
            $cmd = "MYSQL_PWD=" . $E($pass) . " " . $mysqlPath . $hostArg . $E($targetDb) . " < " . $E($baselineSqlPath);
        }

        set_time_limit(0);
        $start = microtime(true);
        $out = [];
        $code = 0;
        exec($cmd . " 2>&1", $out, $code);
        if (!empty($out)) echo implode("\n", $out) . "\n";

        if ($code !== 0) {
            echo "❌ Import failed (exit {$code}).\n";
            return;
        }
        echo " ✓ Imported baseline in " . round(microtime(true) - $start, 1) . "s.\n";

        // Files are NOT reset (by design)
        echo " ℹ Uploads are not part of the reset.\n";
        echo "✅ Demo reset completed: " . date('Y-m-d H:i:s') . "\n";
    }

    // --- Helpers -----------------------------------------------------------

    private function guess_mysql_path()
    {
        $candidates = [
            'mysql',
            '/usr/bin/mysql',
            '/usr/local/bin/mysql',
            'C:\xampp\mysql\bin\mysql.exe',
            'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe',
        ];
        foreach ($candidates as $c) {
            $test = (stripos(PHP_OS, 'WIN') === 0) ? "\"{$c}\" --version" : "$c --version";
            @exec($test . " 2>NUL", $o, $rc);
            if ($rc === 0) return $c;
        }
        return 'mysql';
    }
}
