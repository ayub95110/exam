// assets/spa.js

let currentSubjectKey = '';
let currentTopicId = 0;
let currentSetId = 1;
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

/**
 * คืนค่าชุดข้อสอบทั้งหมดของหัวข้อ ในรูป { "1": [...], "2": [...] }
 * รองรับทั้งข้อมูลแบบเดิม (array) และแบบใหม่ (object แยกชุด)
 */
function getTopicSets(subjectKey, topicId) {
    const raw = DB.questions[subjectKey]?.[topicId];
    if (!raw) return {};
    if (Array.isArray(raw)) return { '1': raw };
    return raw;
}

function getSetQuestions(subjectKey, topicId, setId) {
    return getTopicSets(subjectKey, topicId)[setId] || [];
}

function setLabel(setId) {
    return 'ชุด ' + String(setId).padStart(2, '0');
}

/** suffix ของ key ใน localStorage — ชุด 1 ใช้ key เดิม เพื่อไม่ให้คะแนน/ความคืบหน้าเก่าหาย */
function setKeySuffix(setId) {
    return String(setId) === '1' ? '' : `_s${setId}`;
}

function initRouter() {
    const params = new URLSearchParams(window.location.search);
    const page = params.get('page') || 'home';
    currentSubjectKey = params.get('subject') || '';
    currentTopicId = parseInt(params.get('topic')) || 0;
    currentSetId = parseInt(params.get('set')) || 1;

    const container = document.getElementById('appContainer');
    if (!container) return;
    
    container.innerHTML = '';
    window.scrollTo(0, 0);

    if (page === 'home') {
        renderHome(container);
    } else if (page === 'topics' && DB.subjects[currentSubjectKey]) {
        renderTopics(container);
    } else if (page === 'exam' && DB.subjects[currentSubjectKey] && DB.subjects[currentSubjectKey].topics[currentTopicId]) {
        if (!getTopicSets(currentSubjectKey, currentTopicId)[currentSetId]) currentSetId = 1;
        questions = getSetQuestions(currentSubjectKey, currentTopicId, currentSetId);
        renderExam(container);
    } else if (page === 'note' && DB.subjects[currentSubjectKey] && DB.subjects[currentSubjectKey].topics[currentTopicId]) {
        questions = getSetQuestions(currentSubjectKey, currentTopicId, 1);
        renderNote(container);
    } else {
        renderHome(container);
    }
}

function renderHome(container) {
    let gridHTML = '';
    for (const [sKey, sData] of Object.entries(DB.subjects)) {
        let meta = '';
        if (sKey !== 'memory') {
            const tIds = Object.keys(sData.topics);
            const maxSets = Math.max(...tIds.map(t => Object.keys(getTopicSets(sKey, t)).length));
            meta = tIds.length + ' หัวข้อ · ' + maxSets + ' ชุด';
        } else {
            const tIds = Object.keys(sData.topics);
            meta = tIds.length + ' หมวดสรุปสำคัญ';
        }
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

function scoreBadgeHTML(subjectKey, topicId, setId) {
    const scoreStr = localStorage.getItem(`exam_score_${subjectKey}_${topicId}${setKeySuffix(setId)}`);
    if (!scoreStr) return '';
    const scoreNum = parseInt(scoreStr);
    const isPass = scoreNum >= 60;
    return `<span class="score-badge ${isPass ? 'pass-b' : 'fail-b'}">ได้ ${scoreNum}%</span>`;
}

function renderTopics(container) {
    const subj = DB.subjects[currentSubjectKey];
    let gridHTML = '';
    
    for (const [tid, tData] of Object.entries(subj.topics)) {
        if (currentSubjectKey === 'memory') {
            const qCount = getSetQuestions(currentSubjectKey, tid, 1).length;
            gridHTML += `
                <a href="?page=note&subject=${currentSubjectKey}&topic=${tid}" class="topic-card tc-${subj.color}" onclick="navigate(event, this.href)">
                    <div class="tc-number">${tid}</div>
                    <div class="tc-body">
                        <div class="tc-icon">${tData.icon}</div>
                        <h3 class="tc-title">${esc(tData.short)}</h3>
                        <p class="tc-full">${esc(tData.title)}</p>
                        <div class="tc-meta">${qCount} หัวข้อย่อย</div>
                    </div>
                    <div class="tc-arrow">→</div>
                </a>
            `;
            continue;
        }

        const sets = getTopicSets(currentSubjectKey, tid);
        let setsHTML = '';
        for (const [sid, sQs] of Object.entries(sets)) {
            setsHTML += `
                <a href="?page=exam&subject=${currentSubjectKey}&topic=${tid}&set=${sid}" class="set-chip" onclick="navigate(event, this.href)">
                    <span class="set-chip-label">📝 ${setLabel(sid)}</span>
                    <span class="set-chip-count">${sQs.length} ข้อ</span>
                    ${scoreBadgeHTML(currentSubjectKey, tid, sid)}
                </a>
            `;
        }

        gridHTML += `
            <div class="topic-card has-sets tc-${subj.color}">
                <div class="tc-number">${tid}</div>
                <div class="tc-body">
                    <div class="tc-icon">${tData.icon}</div>
                    <h3 class="tc-title">${esc(tData.short)}</h3>
                    <p class="tc-full">${esc(tData.title)}</p>
                    <div class="tc-sets">${setsHTML}</div>
                </div>
            </div>
        `;
    }

    container.innerHTML = `
        <div class="topics-page">
            <div class="topics-header">
                <a href="?page=home" class="back-link" onclick="navigate(event, this.href)">← กลับหน้าแรก</a>
                <h2 class="topics-title">${subj.emoji} ${esc(subj.title)}</h2>
                <p class="topics-desc">${currentSubjectKey === 'memory' ? 'เลือกหัวข้อที่ต้องการทบทวน' : 'เลือกหัวข้อและชุดข้อสอบที่ต้องการฝึกทำ'} (${esc(subj.subtitle)})</p>
            </div>
            <div class="topics-grid">
                ${gridHTML}
            </div>
        </div>
    `;
}

function renderSetTabs() {
    const sets = getTopicSets(currentSubjectKey, currentTopicId);
    const ids = Object.keys(sets);
    if (ids.length < 2) return '';
    let html = '<div class="set-tabs">';
    ids.forEach(sid => {
        const active = String(sid) === String(currentSetId);
        html += `<a href="?page=exam&subject=${currentSubjectKey}&topic=${currentTopicId}&set=${sid}" class="set-tab ${active ? 'active' : ''}" onclick="navigate(event, this.href)">${setLabel(sid)}</a>`;
    });
    html += '</div>';
    return html;
}

function renderExam(container) {
    const subj = DB.subjects[currentSubjectKey];
    const topic = subj.topics[currentTopicId];
    const label = setLabel(currentSetId);
    
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
                <span class="bc-current">${esc(topic.short)} ${label}</span>
            </div>
            <div class="exam-header eh-${subj.color}">
                <div class="eh-left">
                    <div class="eh-icon">${topic.icon}</div>
                    <div>
                        <h2 class="eh-title">${esc(topic.short)} <span class="eh-set">${label}</span></h2>
                        <p class="eh-desc">${esc(topic.title)}</p>
                        <p class="eh-count">${questions.length} ข้อ</p>
                    </div>
                </div>
                <div class="eh-right">
                    ${renderSetTabs()}
                    <div class="mode-tabs">
                        <button class="mode-tab" id="tabReview" onclick="switchMode('review')">📄 ดูเฉลย</button>
                        <button class="mode-tab active" id="tabQuiz" onclick="switchMode('quiz')">✏️ ทำข้อสอบ</button>
                    </div>
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

    // หน้าข้อสอบ: เลื่อนไปหัวข้อก่อน/ถัดไป โดยคงชุดเดิมไว้ (ถ้ามี)
    const linkFor = (tid) => {
        let url = `?page=${tPage}&subject=${currentSubjectKey}&topic=${tid}`;
        let text = esc(subj.topics[tid].short);
        if (tPage === 'exam') {
            const sid = getTopicSets(currentSubjectKey, tid)[currentSetId] ? currentSetId : 1;
            url += `&set=${sid}`;
            text += ` ${setLabel(sid)}`;
        }
        return { url, text };
    };

    if (prevTopic) {
        const l = linkFor(prevTopic);
        html += `<a href="${l.url}" class="tn-link tn-prev" onclick="navigate(event, this.href)">← ${l.text}</a>`;
    } else {
        html += '<span></span>';
    }
    
    if (nextTopic) {
        const l = linkFor(nextTopic);
        html += `<a href="${l.url}" class="tn-link tn-next" onclick="navigate(event, this.href)">${l.text} →</a>`;
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
