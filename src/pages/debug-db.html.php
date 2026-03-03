<h1>Database Check</h1>

<ul>
  <li>Connected database: <strong><?= htmlspecialchars($dbName ?? '') ?></strong></li>
  <li>Events in table: <strong><?= htmlspecialchars((string)($eventCount ?? 0)) ?></strong></li>
</ul>

<p>If you can see this, PDO + schema + seed worked</p>