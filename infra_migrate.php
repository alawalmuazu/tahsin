<?php
/**
 * Infrastructure Migration v4 — Final
 * Run: http://localhost/SmartSchool/infra_migrate.php
 * Uses correct table names: `permission` and `staff_privileges`
 */
$conn = new mysqli('localhost', 'root', '', 'smartschool');
if ($conn->connect_error) die('DB Error: ' . $conn->connect_error);
$conn->set_charset('utf8mb4');

$results = [];

// ── 1. Create infrastructure table ──────────────────────────────────────────
$sql = "CREATE TABLE IF NOT EXISTS `infrastructure` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `branch_id`   INT UNSIGNED NOT NULL,
  `type`        VARCHAR(60)  NOT NULL DEFAULT '',
  `name`        VARCHAR(150) NOT NULL DEFAULT '',
  `quantity`    SMALLINT     NOT NULL DEFAULT 1,
  `capacity`    SMALLINT     NOT NULL DEFAULT 0,
  `condition`   ENUM('Good','Fair','Poor','Condemned') NOT NULL DEFAULT 'Good',
  `year_built`  SMALLINT     NULL,
  `notes`       TEXT         NULL,
  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_branch` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$conn->query($sql);
$results[] = $conn->errno ? '❌ Table error: ' . $conn->error : '✅ Table `infrastructure` ready.';

// ── 2. Show permission table columns ────────────────────────────────────────
$cols_res = $conn->query("SHOW COLUMNS FROM `permission`");
$cols = [];
while ($c = $cols_res->fetch_assoc()) $cols[] = $c['Field'];
$results[] = '📋 `permission` columns: ' . implode(', ', $cols);

// ── 3. Register in `permission` table ────────────────────────────────────────
$exists = $conn->query("SELECT id FROM `permission` WHERE prefix = 'infrastructure' LIMIT 1");
if ($exists && $exists->num_rows === 0) {
    // Clone a sample row for safe defaults
    $sample = $conn->query("SELECT * FROM `permission` LIMIT 1")->fetch_assoc();
    if ($sample) {
        $row = $sample;
        unset($row['id']);
        if (array_key_exists('prefix',    $row)) $row['prefix']    = 'infrastructure';
        if (array_key_exists('name',      $row)) $row['name']      = 'Infrastructure Register';
        if (array_key_exists('base_url',  $row)) $row['base_url']  = 'infrastructure';
        if (array_key_exists('in_module', $row)) $row['in_module'] = 1;
        if (array_key_exists('icon',      $row)) $row['icon']      = 'fas fa-building';

        $fields = '`' . implode('`, `', array_keys($row)) . '`';
        $placeholders = implode(', ', array_fill(0, count($row), '?'));
        $stmt = $conn->prepare("INSERT INTO `permission` ({$fields}) VALUES ({$placeholders})");
        if ($stmt) {
            $types = str_repeat('s', count($row));
            $vals  = array_values($row);
            $stmt->bind_param($types, ...$vals);
            if ($stmt->execute()) {
                $perm_id = $conn->insert_id;
                $results[] = "✅ Permission registered (id={$perm_id}).";

                // ── 4. Grant to all roles via staff_privileges ────────────────
                $roles = $conn->query("SELECT DISTINCT role_id FROM `staff_privileges` LIMIT 200");
                $granted = 0;
                if ($roles) {
                    while ($r = $roles->fetch_assoc()) {
                        $rid = (int)$r['role_id'];
                        $conn->query("INSERT IGNORE INTO `staff_privileges`
                            (role_id, permission_id, is_view, is_add, is_edit, is_delete)
                            VALUES ({$rid}, {$perm_id}, 1, 1, 1, 1)");
                        $granted++;
                    }
                }
                $results[] = "✅ Permissions granted to {$granted} role(s).";
            } else {
                $results[] = '❌ Execute failed: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $results[] = '❌ Prepare failed: ' . $conn->error;
        }
    }
} else {
    $pm = $exists->fetch_assoc();
    $results[] = '⚠️  Permission already exists (id=' . $pm['id'] . ') — skipped.';
}

$conn->close();
@unlink(__FILE__);

echo '<!DOCTYPE html><html><body style="font-family:monospace;padding:24px;background:#f5f5f5">';
echo '<h3>Infrastructure Register — Migration v4</h3><pre style="background:#fff;padding:16px;border-radius:6px">';
foreach ($results as $r) echo $r . "\n";
echo '</pre><p style="color:#888">Script deleted. Close this tab.</p></body></html>';
