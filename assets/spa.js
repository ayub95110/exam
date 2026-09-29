// assets/spa.js

let currentSubjectKey = '';
let currentTopicId = 0;
let questions = [];

// Ensure DB is loaded
if (typeof DB === 'undefined') {
    console.error("Data not loaded! Make sure data.js is included before spa.js");
}

function esc(s) {
    const d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
}

function initRouter() {
    const params = new URLSearchParams(window.location.search);
    const page = params.get('page') || 'home';
    currentSubjectKey = params.get('subject') || '';
    currentTopicId = parseInt(params.get('topic')) || 0;

    const container = document.getElementById('appContainer');
    if (!container) return;
    
    container.innerHTML = '';
    window.scrollTo(0, 0);

    if (page === 'home') {
        renderHome(container);
    } else if (page === 'topics' && DB.subjects[currentSubjectKey]) {
        renderTopics(container);
    } else if (page === 'exam' && DB.subjects[currentSubjectKey] && DB.subjects[currentSubjectKey].topics[currentTopicId]) {
        questions = DB.questions[currentSubjectKey]?.[currentTopicId] || [];
        renderExam(container);
    } else if (page === 'note' && DB.subjects[currentSubjectKey] && DB.subjects[currentSubjectKey].topics[currentTopicId]) {
        questions = DB.questions[currentSubjectKey]?.[currentTopicId] || [];
        renderNote(container);
    } else {
        renderHome(container);
    }
}

function renderHome(container) {
    let gridHTML = '';
    for (const [sKey, sData] of Object.entries(DB.subjects)) {
        let meta = sKey === 'memory' ? 'สรุปสำคัญ' : (Object.keys(sData.topics).length + ' หัวข้อ');
        gridHTML += `
            <a href="?page=topics&subject=${sKey}" class="home-subject-card card-${sData.color}" onclick="navigate(event, this.href)">
                <div class="hsc-emoji">${sData.emoji}</div>
                <div class="hsc-title">${esc(sData.title)}</div>
                <div class="hsc-meta">${meta}</div>
            </a>
        `;
    }

    container.innerHTML = `
        <div class="home-wrapper">
            <div class="home-card">
                <div class="home-icon">📝</div>
                <h2 class="home-title">ระบบจำลองข้อสอบ</h2>
                <p class="home-highlight">นักวิชาการคอมพิวเตอร์</p>
                <p class="home-desc">
                    ระบบนี้จัดทำขึ้นเพื่อทบทวนความรู้สำหรับเตรียมสอบแข่งขัน<br>
                    เลือกวิชาที่ต้องการจากด้านล่าง
                </p>
                <div class="home-grid">
                    ${gridHTML}
                </div>
            </div>
        </div>
    `;
}

function renderTopics(container) {
    const subj = DB.subjects[currentSubjectKey];
    let gridHTML = '';
    
    for (const [tid, tData] of Object.entries(subj.topics)) {
        let qCount = DB.questions[currentSubjectKey]?.[tid]?.length || 0;
        let tMeta = currentSubjectKey === 'memory' ? 'หัวข้อย่อย' : 'ข้อ';
        let targetPage = currentSubjectKey === 'memory' ? 'note' : 'exam';
        
        let scoreBadge = '';
        if (currentSubjectKey !== 'memory') {
            const scoreStr = localStorage.getItem(`exam_score_${currentSubjectKey}_${tid}`);
            if (scoreStr) {
                const scoreNum = parseInt(scoreStr);
                const isPass = scoreNum >= 60;
                scoreBadge = `<span class="score-badge ${isPass ? 'pass-b' : 'fail-b'}">ทำแล้วได้ ${scoreNum}%</span>`;
            }
        }

        gridHTML += `
            <a href="?page=${targetPage}&subject=${currentSubjectKey}&topic=${tid}" class="topic-card tc-${subj.color}" onclick="navigate(event, this.href)">
                <div class="tc-number">${tid}</div>
                <div class="tc-body">
                    <div class="tc-icon">${tData.icon}</div>
                    <h3 class="tc-title">${esc(tData.short)}</h3>
                    <p class="tc-full">${esc(tData.title)}</p>
                    <div class="tc-meta">${qCount} ${tMeta} ${scoreBadge}</div>
                </div>
                <div class="tc-arrow">→</div>
            </a>
        `;
    }

    container.innerHTML = `
        <div class="topics-page">
            <div class="topics-header">
                <a href="?page=home" class="back-link" onclick="navigate(event, this.href)">← กลับหน้าแรก</a>
                <h2 class="topics-title">${subj.emoji} ${esc(subj.title)}</h2>
                <p class="topics-desc">เลือกหัวข้อที่ต้องการฝึกทำข้อสอบ (${esc(subj.subtitle)})</p>
            </div>
            <div class="topics-grid">
                ${gridHTML}
            </div>
        </div>
    `;
}

function renderExam(container) {
    const subj = DB.subjects[currentSubjectKey];
    const topic = subj.topics[currentTopicId];
    
    let reviewHTML = '';
    questions.forEach((q, idx) => {
        let optsHTML = '';
        q.options.forEach((ot, oi) => {
            const isC = (oi === q.correct);
            optsHTML += `
                <div class="option-item ${isC ? 'correct-option' : ''}">
                    <div class="option-radio">
                        ${isC ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>' : ''}
                    </div>
                    <span class="option-label">${esc(ot)}</span>
                </div>
            `;
        });
        
        reviewHTML += `
            <div class="q-card">
                <div class="q-body">
                    <div class="q-top">
                        <div class="q-number">${idx + 1}</div>
                        <div class="q-content">
                            <h3 class="q-text">${esc(q.text)}</h3>
                            <div class="options-list">${optsHTML}</div>
                        </div>
                    </div>
                    <div class="q-explanation">
                        <div class="q-exp-inner">
                            <div class="q-exp-title">💡 เฉลยและคำอธิบาย</div>
                            <p class="q-exp-text">
                                <strong>ตอบ:</strong> ${esc(q.options[q.correct])}<br>
                                <strong>เหตุผล:</strong> ${esc(q.explanation)}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <div class="exam-page">
            <div class="breadcrumb">
                <a href="?page=home" onclick="navigate(event, this.href)">หน้าแรก</a>
                <span class="bc-sep">›</span>
                <a href="?page=topics&subject=${currentSubjectKey}" onclick="navigate(event, this.href)">${esc(subj.subtitle)}</a>
                <span class="bc-sep">›</span>
                <span class="bc-current">${esc(topic.short)}</span>
            </div>
            <div class="exam-header eh-${subj.color}">
                <div class="eh-left">
                    <div class="eh-icon">${topic.icon}</div>
                    <div>
                        <h2 class="eh-title">${esc(topic.short)}</h2>
                        <p class="eh-desc">${esc(topic.title)}</p>
                        <p class="eh-count">${questions.length} ข้อ</p>
                    </div>
                </div>
                <div class="mode-tabs">
                    <button class="mode-tab" id="tabReview" onclick="switchMode('review')">📄 ดูเฉลย</button>
                    <button class="mode-tab active" id="tabQuiz" onclick="switchMode('quiz')">✏️ ทำข้อสอบ</button>
                </div>
            </div>
            <div id="reviewMode" style="display:none">
                <div class="review-controls">
                    <button id="toggleAnswerBtn" class="toggle-btn toggle-show" onclick="toggleAllAnswers()">
                        <span id="toggleBtnText">👁️ ซ่อนเฉลยทั้งหมด</span>
                    </button>
                </div>
                <div class="question-list" id="questionList">
                    ${reviewHTML}
                </div>
            </div>
            <div id="quizMode">
                <div id="quizWrapper"></div>
            </div>
            ${renderTopicNav()}
        </div>
    `;
    
    // Setup quiz
    answersVisible = true; // reset toggle state
    startQuiz();
}

function renderNote(container) {
    const subj = DB.subjects[currentSubjectKey];
    const topic = subj.topics[currentTopicId];
    
    let noteHTML = '';
    questions.forEach((q, idx) => {
        noteHTML += `
            <div class="q-card">
                <div class="q-body">
                    <div class="q-top">
                        <div class="q-number" style="background:var(--green-50); color:var(--green-600);">${idx + 1}</div>
                        <div class="q-content">
                            <h3 class="q-text" style="color:var(--green-700); font-weight:700; font-size:18px; margin-bottom:12px; line-height:1.5;">${esc(q.title)}</h3>
                            <div class="note-content" style="color:var(--gray-700); line-height:1.8; font-size:15px;">
                                ${esc(q.content).replace(/\n/g, '<br>')}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    container.innerHTML = `
        <div class="exam-page">
            <div class="breadcrumb">
                <a href="?page=home" onclick="navigate(event, this.href)">หน้าแรก</a>
                <span class="bc-sep">›</span>
                <a href="?page=topics&subject=${currentSubjectKey}" onclick="navigate(event, this.href)">${esc(subj.subtitle)}</a>
                <span class="bc-sep">›</span>
                <span class="bc-current">${esc(topic.short)}</span>
            </div>
            <div class="exam-header eh-${subj.color}">
                <div class="eh-left">
                    <div class="eh-icon">${topic.icon}</div>
                    <div>
                        <h2 class="eh-title">${esc(topic.short)}</h2>
                        <p class="eh-desc">${esc(topic.title)}</p>
                        <p class="eh-count">${questions.length} หัวข้อย่อย</p>
                    </div>
                </div>
            </div>
            <div class="question-list">
                ${noteHTML}
            </div>
            ${renderTopicNav('note')}
        </div>
    `;
}

function renderTopicNav(forcedPage) {
    const subj = DB.subjects[currentSubjectKey];
    const topicIds = Object.keys(subj.topics);
    const currentIdx = topicIds.indexOf(String(currentTopicId));
    
    const prevTopic = currentIdx > 0 ? topicIds[currentIdx - 1] : null;
    const nextTopic = currentIdx < topicIds.length - 1 ? topicIds[currentIdx + 1] : null;
    
    let html = '<div class="topic-nav">';
    let tPage = forcedPage || 'exam';
    if (prevTopic) {
        html += `<a href="?page=${tPage}&subject=${currentSubjectKey}&topic=${prevTopic}" class="tn-link tn-prev" onclick="navigate(event, this.href)">← ${esc(subj.topics[prevTopic].short)}</a>`;
    } else {
        html += '<span></span>';
    }
    
    if (nextTopic) {
        html += `<a href="?page=${tPage}&subject=${currentSubjectKey}&topic=${nextTopic}" class="tn-link tn-next" onclick="navigate(event, this.href)">${esc(subj.topics[nextTopic].short)} →</a>`;
    }
    html += '</div>';
    
    return html;
}

function navigate(e, href) {
    if(e) e.preventDefault();
    window.history.pushState({}, '', href);
    initRouter();
}

window.addEventListener('popstate', initRouter);
document.addEventListener('DOMContentLoaded', initRouter);
