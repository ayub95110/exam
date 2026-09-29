/**
 * ============================================================
 * ระบบจำลองข้อสอบ — Application JavaScript
 * ============================================================
 */

/* === Sidebar (Mobile) === */
function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

/* === Toggle Answers (Review Mode) === */
let answersVisible = true;

function toggleAllAnswers() {
    const list = document.getElementById('questionList');
    const btn = document.getElementById('toggleAnswerBtn');
    const txt = document.getElementById('toggleBtnText');
    if (!list) return;

    if (answersVisible) {
        list.classList.add('answers-hidden');
        txt.textContent = '👁️ แสดงเฉลยทั้งหมด';
        btn.classList.remove('toggle-show');
        btn.classList.add('toggle-hide');
    } else {
        list.classList.remove('answers-hidden');
        txt.textContent = '👁️ ซ่อนเฉลยทั้งหมด';
        btn.classList.remove('toggle-hide');
        btn.classList.add('toggle-show');
    }
    answersVisible = !answersVisible;
}

/* === Mode Switching === */
function switchMode(mode) {
    const review = document.getElementById('reviewMode');
    const quiz = document.getElementById('quizMode');
    const tabR = document.getElementById('tabReview');
    const tabQ = document.getElementById('tabQuiz');
    if (!review || !quiz) return;

    if (mode === 'review') {
        review.style.display = 'block';
        quiz.style.display = 'none';
        tabR.classList.add('active');
        tabQ.classList.remove('active');
    } else {
        review.style.display = 'none';
        quiz.style.display = 'block';
        tabR.classList.remove('active');
        tabQ.classList.add('active');
        startQuiz();
    }
}

/* === Quiz Engine === */
let currentQ = 0;
let score = 0;
let answered = [];
let quizFinished = false;
const letters = ['ก', 'ข', 'ค', 'ง'];

function loadProgress() {
    if (typeof currentSubjectKey === 'undefined' || !currentSubjectKey) return false;
    const key = `exam_prog_${currentSubjectKey}_${currentTopicId}`;
    const data = localStorage.getItem(key);
    if (data) {
        try {
            const p = JSON.parse(data);
            if (p.answered && p.answered.length === questions.length) {
                currentQ = p.currentQ || 0;
                score = p.score || 0;
                answered = p.answered;
                quizFinished = !!p.quizFinished;
                return true;
            }
        } catch(e) {}
    }
    return false;
}

function saveProgress() {
    if (typeof currentSubjectKey === 'undefined' || !currentSubjectKey) return;
    const key = `exam_prog_${currentSubjectKey}_${currentTopicId}`;
    const data = { currentQ, score, answered, quizFinished };
    localStorage.setItem(key, JSON.stringify(data));
}

function startQuiz(reset = false) {
    if (reset) {
        if (typeof currentSubjectKey !== 'undefined') {
            localStorage.removeItem(`exam_prog_${currentSubjectKey}_${currentTopicId}`);
        }
    } else if (loadProgress()) {
        renderQuiz();
        return;
    }
    currentQ = 0;
    score = 0;
    answered = new Array(questions.length).fill(null);
    quizFinished = false;
    saveProgress();
    renderQuiz();
}

function renderQuiz() {
    const wrapper = document.getElementById('quizWrapper');
    if (!wrapper || !questions.length) return;

    if (quizFinished) { renderScore(wrapper); return; }

    const q = questions[currentQ];
    const total = questions.length;
    const progress = (currentQ / total) * 100;
    const correctCount = answered.filter(a => a === true).length;
    const wrongCount = answered.filter(a => a === false).length;
    const isAnswered = answered[currentQ] !== null;

    let optsHTML = '';
    q.options.forEach((opt, i) => {
        const isCorrect = i === q.correct;
        let cls = 'quiz-option';
        if (isAnswered) {
            if (isCorrect) cls += ' correct';
            else if (i === answered[currentQ + '_sel']) cls += ' wrong';
        }
        optsHTML += `
            <button class="${cls}" onclick="selectAnswer(${i})" ${isAnswered ? 'disabled' : ''}>
                <span class="opt-letter">${letters[i]}</span>
                <span class="opt-text">${esc(opt)}</span>
            </button>`;
    });

    let expHTML = '';
    if (isAnswered) {
        const ok = answered[currentQ] === true;
        expHTML = `
            <div class="quiz-explanation ${ok ? 'is-correct' : 'is-wrong'}">
                <div class="quiz-exp-result ${ok ? 'correct-r' : 'wrong-r'}">
                    ${ok ? '✅ ถูกต้อง!' : '❌ ไม่ถูกต้อง'}
                </div>
                <p><strong>คำตอบที่ถูก:</strong> ${esc(q.options[q.correct])}<br>
                <strong>อธิบาย:</strong> ${esc(q.explanation)}</p>
            </div>`;
    }

    const isLast = currentQ === total - 1;
    const allDone = answered.every(a => a !== null);

    wrapper.innerHTML = `
        <div class="quiz-progress"><div class="quiz-progress-bar" style="width:${progress}%"></div></div>
        <div class="quiz-stats">
            <div class="quiz-stat"><span class="dot dot-total"></span> ข้อ ${currentQ+1} / ${total}</div>
            <div class="quiz-stat"><span class="dot dot-correct"></span> ถูก ${correctCount}</div>
            <div class="quiz-stat"><span class="dot dot-wrong"></span> ผิด ${wrongCount}</div>
        </div>
        <div class="quiz-q-card">
            <div class="quiz-q-body">
                <div class="quiz-q-header">
                    <span class="quiz-q-number">คำถามข้อที่ ${currentQ+1} / ${total}</span>
                </div>
                <p class="quiz-q-text">${esc(q.text)}</p>
                <div class="quiz-options">${optsHTML}</div>
                ${expHTML}
            </div>
        </div>
        <div class="quiz-nav">
            <button class="quiz-btn quiz-btn-secondary" onclick="prevQ()" ${currentQ===0?'disabled':''}>← ข้อก่อนหน้า</button>
            ${isLast && allDone
                ? `<button class="quiz-btn quiz-btn-primary" onclick="finishQuiz()">ดูคะแนน →</button>`
                : `<button class="quiz-btn quiz-btn-primary" onclick="nextQ()" ${!isAnswered?'disabled':''}>ข้อถัดไป →</button>`
            }
        </div>`;
}

function selectAnswer(idx) {
    if (answered[currentQ] !== null) return;
    const ok = idx === questions[currentQ].correct;
    answered[currentQ] = ok;
    answered[currentQ + '_sel'] = idx;
    if (ok) score++;
    saveProgress();
    renderQuiz();
}

function nextQ() {
    if (currentQ < questions.length - 1) { currentQ++; saveProgress(); renderQuiz(); scrollQuiz(); }
}
function prevQ() {
    if (currentQ > 0) { currentQ--; saveProgress(); renderQuiz(); scrollQuiz(); }
}
function saveScore() {
    if (typeof currentSubjectKey === 'undefined' || !currentSubjectKey) return;
    const key = `exam_score_${currentSubjectKey}_${currentTopicId}`;
    const pct = Math.round((score / questions.length) * 100);
    const existing = localStorage.getItem(key);
    if (!existing || parseInt(existing) < pct) {
        localStorage.setItem(key, pct);
    }
}
function finishQuiz() {
    quizFinished = true;
    saveProgress();
    saveScore();
    renderQuiz();
    scrollQuiz();
}
function scrollQuiz() {
    const w = document.getElementById('quizWrapper');
    if (w) w.scrollIntoView({ behavior:'smooth', block:'start' });
}

function renderScore(wrapper) {
    const total = questions.length;
    const pct = Math.round((score / total) * 100);
    const pass = pct >= 60;
    const circ = 2 * Math.PI * 65;
    const off = circ - (pct / 100) * circ;

    wrapper.innerHTML = `
        <div class="score-card">
            <div class="score-ring">
                <svg viewBox="0 0 150 150">
                    <circle class="score-ring-bg" cx="75" cy="75" r="65"/>
                    <circle class="score-ring-fill ${pass?'pass':'fail'}" cx="75" cy="75" r="65"
                        stroke-dasharray="${circ}" stroke-dashoffset="${circ}" id="scoreCircle"/>
                </svg>
                <div class="score-ring-text">
                    <span class="score-percent">${pct}%</span>
                    <span class="score-label">คะแนน</span>
                </div>
            </div>
            <h2 class="score-title ${pass?'pass-t':'fail-t'}">
                ${pass ? '🎉 ยอดเยี่ยม! ผ่านเกณฑ์' : '📖 ต้องทบทวนเพิ่มเติม'}
            </h2>
            <p class="score-detail">ตอบถูก ${score} จาก ${total} ข้อ (เกณฑ์ผ่าน ≥ 60%)</p>
            <div class="score-actions">
                <button class="quiz-btn quiz-btn-primary" onclick="startQuiz(true)">🔄 ทำใหม่อีกครั้ง</button>
                <button class="quiz-btn quiz-btn-secondary" onclick="switchMode('review')">📄 ดูเฉลยทั้งหมด</button>
            </div>
        </div>`;

    requestAnimationFrame(() => {
        setTimeout(() => {
            const el = document.getElementById('scoreCircle');
            if (el) el.style.strokeDashoffset = off;
        }, 100);
    });
}

function esc(s) {
    const d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
}

function renderTopicScores() {
    const metas = document.querySelectorAll('.tc-meta[id^="score_"]');
    metas.forEach(meta => {
        const idParts = meta.id.split('_'); 
        if (idParts.length >= 3) {
            const subj = idParts[1];
            const tid = idParts[2];
            if (subj === 'memory') return; // Skip memory subjects
            const scoreStr = localStorage.getItem(`exam_score_${subj}_${tid}`);
            if (scoreStr) {
                const scoreNum = parseInt(scoreStr);
                const isPass = scoreNum >= 60;
                const badge = document.createElement('span');
                badge.className = `score-badge ${isPass ? 'pass-b' : 'fail-b'}`;
                badge.textContent = `ทำแล้วได้ ${scoreNum}%`;
                meta.appendChild(badge);
            }
        }
    });
}

// Initialize default mode
if (document.getElementById('quizWrapper') && typeof questions !== 'undefined' && questions.length > 0) {
    startQuiz();
}

// Render scores on topics page
renderTopicScores();
