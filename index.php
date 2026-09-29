<?php
/**
 * ============================================================
 * ระบบจำลองข้อสอบ — นักวิชาการคอมพิวเตอร์
 * Main Entry Point (Router + UI)
 * ============================================================
 */

// === Subject & Topic Metadata ===
$subjects = [
    'general' => [
        'title' => 'วิชาความรู้ความสามารถทั่วไป',
        'subtitle' => 'ภาค ก.',
        'color' => 'blue',
        'emoji' => '📚',
        'topics' => [
            1 => [
                'title' => 'ความรู้ทั่วไปเกี่ยวกับสภาพแวดล้อม สถานการณ์ปัจจุบันทางการเมือง เศรษฐกิจ สังคม และเทคโนโลยีของประเทศไทย',
                'short' => 'สภาพแวดล้อม การเมือง เศรษฐกิจ สังคม',
                'icon' => '🌍'
            ],
            2 => [
                'title' => 'ความรู้ทั่วไปเกี่ยวกับคุณธรรม จริยธรรม และการเป็นข้าราชการที่ดี',
                'short' => 'คุณธรรม จริยธรรม',
                'icon' => '⚖️'
            ],
            3 => [
                'title' => 'ความรู้ทั่วไปเกี่ยวกับสถาบัน ชาติ ศาสนา พระมหากษัตริย์',
                'short' => 'ชาติ ศาสนา พระมหากษัตริย์',
                'icon' => '🇹🇭'
            ],
            4 => [
                'title' => 'ความรู้ทั่วไปเกี่ยวกับรัฐธรรมนูญแห่งราชอาณาจักรไทย',
                'short' => 'รัฐธรรมนูญ',
                'icon' => '📜'
            ],
            5 => [
                'title' => 'ความรู้เกี่ยวกับ พ.ร.บ. ระเบียบบริหารราชการแผ่นดิน พ.ศ. ๒๕๓๔ และที่แก้ไขเพิ่มเติม',
                'short' => 'พ.ร.บ. ระเบียบบริหารราชการแผ่นดิน',
                'icon' => '🏛️'
            ],
            6 => [
                'title' => 'ความรู้เกี่ยวกับ พ.ร.ฎ. ว่าด้วยหลักเกณฑ์และวิธีการบริหารกิจการบ้านเมืองที่ดี พ.ศ. ๒๕๔๖ และที่แก้ไขเพิ่มเติม',
                'short' => 'พ.ร.ฎ. บริหารกิจการบ้านเมืองที่ดี',
                'icon' => '✅'
            ],
            7 => [
                'title' => 'ความรู้เกี่ยวกับประมวลจริยธรรมข้าราชการพลเรือน',
                'short' => 'ประมวลจริยธรรมข้าราชการ',
                'icon' => '📋'
            ],
            8 => [
                'title' => 'ความรู้เกี่ยวกับ พ.ร.บ. ระเบียบข้าราชการพลเรือน พ.ศ. ๒๕๕๑ และที่แก้ไขเพิ่มเติม',
                'short' => 'พ.ร.บ. ระเบียบข้าราชการพลเรือน',
                'icon' => '👔'
            ],
            9 => [
                'title' => 'ความคิดตรรกะและความสามารถในการคิดวิเคราะห์',
                'short' => 'ตรรกะ และ การคิดวิเคราะห์',
                'icon' => '🧠'
            ],
        ]
    ],
    'computer' => [
        'title' => 'วิชาความรู้ความสามารถที่ใช้เฉพาะตำแหน่ง (นักวิชาการคอมพิวเตอร์)',
        'subtitle' => 'ภาค ข.',
        'color' => 'violet',
        'emoji' => '💻',
        'topics' => [
            1 => [
                'title' => 'ระบบเครือข่ายคอมพิวเตอร์ ระบบเครือข่ายอินเทอร์เน็ต และระบบเครือข่ายอินทราเน็ต',
                'short' => 'ระบบเครือข่ายคอมพิวเตอร์',
                'icon' => '🌐'
            ],
            2 => [
                'title' => 'การใช้คอมพิวเตอร์ ระบบฮาร์ดแวร์ (Hardware) ระบบซอฟต์แวร์ (Software)',
                'short' => 'ฮาร์ดแวร์ / ซอฟต์แวร์',
                'icon' => '🖥️'
            ],
            3 => [
                'title' => 'ระบบสารสนเทศ การพัฒนาระบบสารสนเทศ วิเคราะห์และออกแบบระบบ การพัฒนาระบบฐานข้อมูล',
                'short' => 'ระบบสารสนเทศ / ฐานข้อมูล',
                'icon' => '🗄️'
            ],
            4 => [
                'title' => 'การใช้ภาษาทางคอมพิวเตอร์ เช่น PHP, JavaScript, MySQL, MSSQL',
                'short' => 'ภาษาคอมพิวเตอร์',
                'icon' => '💡'
            ],
            5 => [
                'title' => 'การพัฒนา Web Application เช่น PHP, HTML, JavaScript และเทคโนโลยีทางเว็บ',
                'short' => 'Web Application',
                'icon' => '🕸️'
            ],
            6 => [
                'title' => 'พ.ร.บ. ว่าด้วยการกระทำความผิดเกี่ยวกับคอมพิวเตอร์ พ.ศ. ๒๕๕๐ และที่แก้ไขเพิ่มเติม',
                'short' => 'พ.ร.บ. คอมพิวเตอร์',
                'icon' => '⚠️'
            ],
            7 => [
                'title' => 'พ.ร.บ. การรักษาความมั่นคงปลอดภัยไซเบอร์ พ.ศ. ๒๕๖๒',
                'short' => 'พ.ร.บ. ไซเบอร์',
                'icon' => '🛡️'
            ],
            8 => [
                'title' => 'พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล พ.ศ. ๒๕๖๒ (PDPA)',
                'short' => 'พ.ร.บ. PDPA',
                'icon' => '🔒'
            ],
        ]
    ],
    'memory' => [
        'title' => 'ความรู้ที่ต้องจำ',
        'subtitle' => 'สรุปสำคัญ',
        'color' => 'green',
        'emoji' => '🧠',
        'topics' => [
            1 => [
                'title' => 'รวมตัวเลขและสถิติที่มักออกสอบ',
                'short' => 'ตัวเลขที่ต้องจำ',
                'icon' => '🔢'
            ],
        ]
    ]
];

// === Routing ===
$page = $_GET['page'] ?? 'home';
$subjectKey = $_GET['subject'] ?? '';
$topicId = isset($_GET['topic']) ? (int)$_GET['topic'] : 0;

// Validate routes
$currentSubject = null;
$currentTopic = null;
$questions = [];

if ($page === 'topics' && isset($subjects[$subjectKey])) {
    $currentSubject = $subjects[$subjectKey];
} elseif (($page === 'exam' || $page === 'note') && isset($subjects[$subjectKey]) && isset($subjects[$subjectKey]['topics'][$topicId])) {
    $currentSubject = $subjects[$subjectKey];
    $currentTopic = $subjects[$subjectKey]['topics'][$topicId];
    // Load questions from data file
    $dataFile = __DIR__ . "/data/{$subjectKey}/topic_" . str_pad($topicId, 2, '0', STR_PAD_LEFT) . ".php";
    if (file_exists($dataFile)) {
        $questions = include $dataFile;
    }
} else {
    $page = 'home';
}

$questionsJson = json_encode($questions, JSON_UNESCAPED_UNICODE);

// Count total questions per subject
function countSubjectQuestions($subjectKey, $topics) {
    $total = 0;
    foreach (array_keys($topics) as $tid) {
        $f = __DIR__ . "/data/{$subjectKey}/topic_" . str_pad($tid, 2, '0', STR_PAD_LEFT) . ".php";
        if (file_exists($f)) {
            $qs = include $f;
            $total += count($qs);
        }
    }
    return $total;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจำลองข้อสอบ — นักวิชาการคอมพิวเตอร์</title>
    <meta name="description" content="ระบบจำลองข้อสอบสำหรับเตรียมสอบแข่งขันตำแหน่งนักวิชาการคอมพิวเตอร์ ภาค ก. และ ภาค ข.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>



    <!-- ============ MAIN ============ -->
    <main class="main-content">
        <!-- Mobile Header -->
        <div class="mobile-header">
            <span class="mobile-title">ระบบจำลองข้อสอบ</span>
        </div>

        <?php if ($page === 'home'): ?>
        <!-- ================== HOME ================== -->
        <div class="home-wrapper">
            <div class="home-card">
                <div class="home-icon">📝</div>
                <h2 class="home-title">ระบบจำลองข้อสอบ</h2>
                <p class="home-highlight">นักวิชาการคอมพิวเตอร์</p>
                <p class="home-desc">
                    ระบบนี้จัดทำขึ้นเพื่อทบทวนความรู้สำหรับเตรียมสอบแข่งขัน<br>
                    เลือกวิชาที่ต้องการจากด้านล่าง หรือจากเมนูด้านซ้ายมือ
                </p>
                <div class="home-grid">
                    <a href="?page=topics&subject=general" class="home-subject-card card-blue">
                        <div class="hsc-emoji">📚</div>
                        <div class="hsc-title">ภาค ก. ความรู้ทั่วไป</div>
                        <div class="hsc-meta">9 หัวข้อ</div>
                    </a>
                    <a href="?page=topics&subject=computer" class="home-subject-card card-violet">
                        <div class="hsc-emoji">💻</div>
                        <div class="hsc-title">ภาค ข. วิชาเฉพาะตำแหน่ง</div>
                        <div class="hsc-meta">8 หัวข้อ</div>
                    </a>
                    <a href="?page=topics&subject=memory" class="home-subject-card card-green">
                        <div class="hsc-emoji">🧠</div>
                        <div class="hsc-title">ความรู้ที่ต้องจำ</div>
                        <div class="hsc-meta">สรุปสำคัญ</div>
                    </a>
                </div>
            </div>
        </div>

        <?php elseif ($page === 'topics'): ?>
        <!-- ================== TOPICS LIST ================== -->
        <div class="topics-page">
            <div class="topics-header">
                <a href="?page=home" class="back-link">← กลับหน้าแรก</a>
                <h2 class="topics-title"><?= $currentSubject['emoji'] ?> <?= $currentSubject['title'] ?></h2>
                <p class="topics-desc">เลือกหัวข้อที่ต้องการฝึกทำข้อสอบ (<?= $currentSubject['subtitle'] ?>)</p>
            </div>
            <div class="topics-grid">
                <?php foreach ($currentSubject['topics'] as $tid => $t): ?>
                <?php
                    $df = __DIR__ . "/data/{$subjectKey}/topic_" . str_pad($tid, 2, '0', STR_PAD_LEFT) . ".php";
                    $qCount = 0;
                    if (file_exists($df)) { $qs = include $df; $qCount = count($qs); }
                    $targetPage = ($subjectKey === 'memory') ? 'note' : 'exam';
                ?>
                <a href="?page=<?= $targetPage ?>&subject=<?= $subjectKey ?>&topic=<?= $tid ?>" class="topic-card tc-<?= $currentSubject['color'] ?>">
                    <div class="tc-number"><?= $tid ?></div>
                    <div class="tc-body">
                        <div class="tc-icon"><?= $t['icon'] ?></div>
                        <h3 class="tc-title"><?= htmlspecialchars($t['short']) ?></h3>
                        <p class="tc-full"><?= htmlspecialchars($t['title']) ?></p>
                        <div class="tc-meta" id="score_<?= $subjectKey ?>_<?= $tid ?>"><?= $qCount ?> <?= ($subjectKey === 'memory') ? 'หัวข้อย่อย' : 'ข้อ' ?></div>
                    </div>
                    <div class="tc-arrow">→</div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php elseif ($page === 'exam'): ?>
        <!-- ================== EXAM PAGE ================== -->
        <div class="exam-page" id="examPage">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="?page=home">หน้าแรก</a>
                <span class="bc-sep">›</span>
                <a href="?page=topics&subject=<?= $subjectKey ?>"><?= $currentSubject['subtitle'] ?></a>
                <span class="bc-sep">›</span>
                <span class="bc-current"><?= $currentTopic['short'] ?></span>
            </div>

            <!-- Header -->
            <div class="exam-header eh-<?= $currentSubject['color'] ?>">
                <div class="eh-left">
                    <div class="eh-icon"><?= $currentTopic['icon'] ?></div>
                    <div>
                        <h2 class="eh-title"><?= htmlspecialchars($currentTopic['short']) ?></h2>
                        <p class="eh-desc"><?= htmlspecialchars($currentTopic['title']) ?></p>
                        <p class="eh-count"><?= count($questions) ?> ข้อ</p>
                    </div>
                </div>
                <div class="mode-tabs">
                    <button class="mode-tab" id="tabReview" onclick="switchMode('review')">📄 ดูเฉลย</button>
                    <button class="mode-tab active" id="tabQuiz" onclick="switchMode('quiz')">✏️ ทำข้อสอบ</button>
                </div>
            </div>

            <!-- REVIEW MODE -->
            <div id="reviewMode" style="display:none">
                <div class="review-controls">
                    <button id="toggleAnswerBtn" class="toggle-btn toggle-show" onclick="toggleAllAnswers()">
                        <span id="toggleBtnText">👁️ ซ่อนเฉลยทั้งหมด</span>
                    </button>
                </div>
                <div class="question-list" id="questionList">
                    <?php foreach ($questions as $idx => $q): ?>
                    <div class="q-card">
                        <div class="q-body">
                            <div class="q-top">
                                <div class="q-number"><?= $idx + 1 ?></div>
                                <div class="q-content">
                                    <h3 class="q-text"><?= htmlspecialchars($q['text']) ?></h3>
                                    <div class="options-list">
                                        <?php foreach ($q['options'] as $oi => $ot): ?>
                                        <?php $isC = ($oi === $q['correct']); ?>
                                        <div class="option-item <?= $isC ? 'correct-option' : '' ?>">
                                            <div class="option-radio">
                                                <?php if ($isC): ?>
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                <?php endif; ?>
                                            </div>
                                            <span class="option-label"><?= htmlspecialchars($ot) ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="q-explanation">
                            <div class="q-exp-inner">
                                <div class="q-exp-title">💡 เฉลยและคำอธิบาย</div>
                                <p class="q-exp-text">
                                    <strong>ตอบ:</strong> <?= htmlspecialchars($q['options'][$q['correct']]) ?><br>
                                    <strong>เหตุผล:</strong> <?= htmlspecialchars($q['explanation']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- QUIZ MODE -->
            <div id="quizMode">
                <div id="quizWrapper"></div>
            </div>

            <!-- Topic Navigation (prev/next topic) -->
            <div class="topic-nav">
                <?php
                $topicIds = array_keys($currentSubject['topics']);
                $currentIdx = array_search($topicId, $topicIds);
                $prevTopic = $currentIdx > 0 ? $topicIds[$currentIdx - 1] : null;
                $nextTopic = $currentIdx < count($topicIds) - 1 ? $topicIds[$currentIdx + 1] : null;
                ?>
                <?php if ($prevTopic): ?>
                <a href="?page=exam&subject=<?= $subjectKey ?>&topic=<?= $prevTopic ?>" class="tn-link tn-prev">
                    ← <?= $currentSubject['topics'][$prevTopic]['short'] ?>
                </a>
                <?php else: ?>
                <span></span>
                <?php endif; ?>
                <?php if ($nextTopic): ?>
                <a href="?page=exam&subject=<?= $subjectKey ?>&topic=<?= $nextTopic ?>" class="tn-link tn-next">
                    <?= $currentSubject['topics'][$nextTopic]['short'] ?> →
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php elseif ($page === 'note'): ?>
        <!-- ================== NOTE PAGE ================== -->
        <div class="exam-page">
            <div class="breadcrumb">
                <a href="?page=home">หน้าแรก</a>
                <span class="bc-sep">›</span>
                <a href="?page=topics&subject=<?= $subjectKey ?>"><?= $currentSubject['subtitle'] ?></a>
                <span class="bc-sep">›</span>
                <span class="bc-current"><?= $currentTopic['short'] ?></span>
            </div>
            <div class="exam-header eh-<?= $currentSubject['color'] ?>">
                <div class="eh-left">
                    <div class="eh-icon"><?= $currentTopic['icon'] ?></div>
                    <div>
                        <h2 class="eh-title"><?= htmlspecialchars($currentTopic['short']) ?></h2>
                        <p class="eh-desc"><?= htmlspecialchars($currentTopic['title']) ?></p>
                        <p class="eh-count"><?= count($questions) ?> หัวข้อย่อย</p>
                    </div>
                </div>
            </div>
            <div class="question-list">
                <?php foreach ($questions as $idx => $q): ?>
                <div class="q-card">
                    <div class="q-body">
                        <div class="q-top">
                            <div class="q-number" style="background:var(--green-50); color:var(--green-600);"><?= $idx + 1 ?></div>
                            <div class="q-content">
                                <h3 class="q-text" style="color:var(--green-700); font-weight:700; font-size:18px; margin-bottom:12px; line-height:1.5;"><?= htmlspecialchars($q['title']) ?></h3>
                                <div class="note-content" style="color:var(--gray-700); line-height:1.8; font-size:15px;">
                                    <?= nl2br(htmlspecialchars($q['content'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="topic-nav">
                <?php
                $topicIds = array_keys($currentSubject['topics']);
                $currentIdx = array_search($topicId, $topicIds);
                $prevTopic = $currentIdx > 0 ? $topicIds[$currentIdx - 1] : null;
                $nextTopic = $currentIdx < count($topicIds) - 1 ? $topicIds[$currentIdx + 1] : null;
                ?>
                <?php if ($prevTopic): ?>
                <a href="?page=note&subject=<?= $subjectKey ?>&topic=<?= $prevTopic ?>" class="tn-link tn-prev">← <?= $currentSubject['topics'][$prevTopic]['short'] ?></a>
                <?php else: ?><span></span><?php endif; ?>
                <?php if ($nextTopic): ?>
                <a href="?page=note&subject=<?= $subjectKey ?>&topic=<?= $nextTopic ?>" class="tn-link tn-next"><?= $currentSubject['topics'][$nextTopic]['short'] ?> →</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <script>
        const questions = <?= $questionsJson ?>;
        const currentSubjectKey = '<?= $subjectKey ?>';
        const currentTopicId = <?= $topicId ?>;
    </script>
    <script src="assets/app.js"></script>
</body>
</html>