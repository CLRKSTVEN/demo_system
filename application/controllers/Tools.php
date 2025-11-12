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
     * Reset the demo DB to the baseline (Gold Master) and optionally reset uploads.
     * Usage (localhost or cPanel):
     *   php index.php tools reset_demo
     *
     * What it does:
     *  - Drops & recreates database 'demo_a'
     *  - Imports application/backup/srmsportal_demo1.sql
     *  - If upload_master/ exists, replaces upload/ with it
     */
    public function reset_demo()
    {
        // === HARD SAFETY RAILS: we only ever touch these specific resources ===
        $targetDb        = 'demo_a';
        // $targetDb = 'srmsportal_demo1';
        $baselineSqlPath = FCPATH . 'application/backup/srmsportal_demo1.sql'; // already in your repo
        $uploadsLive     = FCPATH . 'upload';           // your current uploads
        $uploadsMaster   = FCPATH . 'upload_master';    // put your baseline files here (optional)

        // Get DB creds from CI config
        $host = $this->db->hostname ?: 'localhost';
        $port = $this->db->port ?: 3306;
        $user = $this->db->username;
        $pass = $this->db->password;

        // Refuse to run if config doesn't match 'demo_a'
        if (strcasecmp($this->db->database, $targetDb) !== 0) {
            echo "❌ Safety check: CI is currently connected to '{$this->db->database}', not '{$targetDb}'.\n";
            echo "   Update application/config/database.php to point to '{$targetDb}' before running.\n";
            return;
        }

        if (!is_file($baselineSqlPath)) {
            echo "❌ Baseline SQL not found: {$baselineSqlPath}\n";
            return;
        }

        // Try to locate mysql client binaries (cPanel/Linux/mac often have them in PATH; XAMPP has local paths)
        $mysql     = $this->guess_mysql_path();
        $mysqldump = $this->guess_mysqldump_path(); // not strictly needed here, but useful if you add a backup step

        echo "[" . date('Y-m-d H:i:s') . "] Starting demo reset…\n";
        echo " DB target: {$targetDb}\n";
        echo " SQL file : {$baselineSqlPath}\n";

        // 1) Drop & recreate database
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

        // 2) Import baseline
        $E = function ($s) {
            return escapeshellarg($s);
        };

        $isWin = (stripos(PHP_OS, 'WIN') === 0);
        $mysqlPath = $E($mysql);
        $hostArg   = " -h " . $E($host) . " -P " . (int)$port . " -u " . $E($user) . " ";

        // Build the command differently for Windows vs *nix
        if ($isWin) {
            // Windows: use -p"password" if not empty
            $passArg = strlen($pass) ? ' -p' . $E($pass) : '';
            $cmd = $mysqlPath . $hostArg . $passArg . " " . $E($targetDb) . " < " . $E($baselineSqlPath);
        } else {
            // Linux/Mac: safer to use MYSQL_PWD env var
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


        // 3) (Optional) reset uploads folder if a master exists
        if (is_dir($uploadsMaster)) {
            $ok = $this->reset_uploads($uploadsLive, $uploadsMaster);
            if ($ok) echo " ✓ Reset uploads/ from upload_master/.\n";
            else     echo " ⚠ Skipped uploads reset (permissions or path issue).\n";
        } else {
            echo " ℹ No upload_master/ directory found — uploads reset skipped.\n";
        }

        echo "✅ Demo reset completed: " . date('Y-m-d H:i:s') . "\n";
    }

    // --- Helpers -----------------------------------------------------------

    private function guess_mysql_path()
    {
        // Common locations
        $candidates = [
            'mysql', // if in PATH
            '/usr/bin/mysql',
            '/usr/local/bin/mysql',
            'C:\xampp\mysql\bin\mysql.exe',
            'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe',
        ];
        foreach ($candidates as $c) {
            // On Windows, file_exists() for "mysql" won't work; try running --version silently
            $test = (stripos(PHP_OS, 'WIN') === 0) ? "\"{$c}\" --version" : "$c --version";
            @exec($test . " 2>NUL", $o, $rc);
            if ($rc === 0) return $c;
        }
        return 'mysql'; // fallback to PATH
    }

    private function guess_mysqldump_path()
    {
        $candidates = [
            'mysqldump',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            'C:\xampp\mysql\bin\mysqldump.exe',
            'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe',
        ];
        foreach ($candidates as $c) {
            @exec((stripos(PHP_OS, 'WIN') === 0 ? "\"{$c}\" --version" : "$c --version") . " 2>NUL", $o, $rc);
            if ($rc === 0) return $c;
        }
        return 'mysqldump';
    }

    private function reset_uploads($liveDir, $masterDir)
    {
        // Remove liveDir and copy masterDir → liveDir (cross-platform best effort)
        $this->rrmdir($liveDir);
        return $this->rcopy($masterDir, $liveDir);
    }

    private function rrmdir($dir)
    {
        if (!is_dir($dir)) return true;
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            $file->isDir() ? @rmdir($file->getRealPath()) : @unlink($file->getRealPath());
        }
        return @rmdir($dir);
    }

    private function rcopy($src, $dst)
    {
        if (!is_dir($src)) return false;
        if (!is_dir($dst) && !@mkdir($dst, 0775, true)) return false;
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($it as $item) {
            $target = $dst . DIRECTORY_SEPARATOR . $it->getSubPathName();
            if ($item->isDir()) {
                if (!is_dir($target) && !@mkdir($target, 0775, true)) return false;
            } else {
                if (!@copy($item->getPathname(), $target)) return false;
            }
        }
        return true;
    }
}
