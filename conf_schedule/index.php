<?php
/**
 * @global  \CMain $APPLICATION
 */
use App\Models\ORM\ConfScheduleTable;
use Bitrix\Main\Page\Asset;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

$APPLICATION->SetTitle("Расписание конференции");

$grouped = [];

/**
 * Вывод данных из таблицы
 */
$dbResult = ConfScheduleTable::getList([
"select" => [
    'ID',
    'START_DATETIME',
    'END_DATETIME',

    'SPEAKER_NAME'   => 'SPEAKER.NAME',
    'SPEAKER_POSITION' => 'SPEAKER_PROP.POSITION',
    'ROOM_NAME'      => 'ROOM.NAME',
    'CONF_NAME'      => 'CONF.NAME',

     'TOPIC'],
	//"filter" => ['CONF_ID' => 43],
"order" => ["START_DATETIME" => 'ASC'],
]);

if ($dbResult) {

    // Группируем по конференции, затем по дате
    while ($row = $dbResult->fetch()) {
        $confName = $row['CONF_NAME'] ?: 'Без конференции';
        $date     = $row['START_DATETIME']->format('d.m.Y');
        $grouped[$confName][$date][] = $row;
    }

}
?>
    <div class="container my-5">
    <h1 class="mb-4">Расписание конференций</h1>

    <?php foreach ($grouped as $confName => $dates): ?>
        <section class="mb-5">
            <h2 class="h4 mb-3 text-primary"><?= htmlspecialcharsbx($confName) ?></h2>

            <?php foreach ($dates as $date => $items): ?>
                <h3 class="h6 text-muted mb-3">
                    <i class="bi bi-calendar-event"></i> <?= htmlspecialcharsbx($date) ?>
                </h3>

                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 140px;">Время</th>
                                <th>Тема</th>
                                <th style="width: 220px;">Спикер</th>
                                <th style="width: 140px;">Аудитория</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <?php
                                    $start = $item['START_DATETIME']->format('H:i');
                                $end   = $item['END_DATETIME']->format('H:i');

                                // Помечаем перерывы и регистрацию другим цветом
                                $topicLower = mb_strtolower($item['TOPIC']);
                                $isBreak    = str_contains($topicLower, 'перерыв')
                                           || str_contains($topicLower, 'кофе')
                                           || str_contains($topicLower, 'регистрация');
                                ?>
                                <tr class="<?= $isBreak ? 'table-warning' : '' ?>">
                                    <td class="fw-semibold">
                                        <?= $start ?> – <?= $end ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialcharsbx($item['TOPIC']) ?>
                                        <?php if ($isBreak): ?>
                                            <span class="badge bg-secondary ms-1">перерыв</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['SPEAKER_NAME']): ?>
                                            <div class="fw-semibold">
                                                <?= htmlspecialcharsbx($item['SPEAKER_NAME']) ?>
                                            </div>
                                            <?php if ($item['SPEAKER_POSITION']): ?>
                                                <div class="text-muted small">
                                                    <?= htmlspecialcharsbx($item['SPEAKER_POSITION']) ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['ROOM_NAME']): ?>
                                            <span class="badge bg-info text-dark">
                                                <?= htmlspecialcharsbx($item['ROOM_NAME']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>

    <?php if (empty($grouped)): ?>
        <div class="alert alert-info">Расписание пока пусто.</div>
    <?php endif; ?>
</div>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
