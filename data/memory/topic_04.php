<?php
// สรุปการพัฒนาระบบ ฐานข้อมูล และเว็บแอปพลิเคชัน ภาค ข.
return [
    [
        'title' => "วงจรการพัฒนาระบบ SDLC (System Development Life Cycle)",
        'content' => "SDLC ประกอบด้วย 7 ขั้นตอนหลัก:\n1. การวางแผนและศึกษาความเป็นไปได้ (Planning & Feasibility Study): ศึกษาความคุ้มค่าด้านเทคนิค การเงิน เวลา\n2. การวิเคราะห์ระบบ (System Analysis): รวบรวม Requirement จากผู้ใช้งาน และเขียน Data Flow Diagram (DFD)\n3. การออกแบบระบบ (System Design): ออกแบบ Database Schema, ER-Diagram, UI/UX, Architecture\n4. การพัฒนาระบบ (Development / Coding): ลงมือเขียนโปรแกรมตามที่ดีไซน์ไว้ด้วยภาษาคอมพิวเตอร์\n5. การทดสอบระบบ (System Testing): Unit Test -> Integration Test -> System Test -> User Acceptance Test (UAT)\n6. การติดตั้งและนำไปใช้ (Deployment / Implementation): ติดตั้งขึ้นเซิร์ฟเวอร์จริง ถ่ายโอนข้อมูล อบรมผู้ใช้\n7. การบำรุงรักษา (Maintenance): แก้ไข Bug (Corrective), ปรับปรุงตามสภาพแวดล้อมใหม่ (Adaptive), พัฒนาฟีเจอร์เพิ่ม (Perfective)"
    ],
    [
        'title' => "โมเดลการพัฒนาซอฟต์แวร์: Waterfall vs Agile vs DevOps",
        'content' => "• Waterfall Model: ทำงานตามลำดับขั้นเป็นเส้นตรงทีละสเต็ป ไม่ย้อนกลับ เหมาะกับโครงการที่ Requirement นิ่ง ชัดเจนแน่นอน\n• Agile Methodology: แนวคิดการพัฒนาแบบทำซ้ำ (Iterative) และเพิ่มทีละส่วน (Incremental) ยืดหยุ่นสูง รับมือกับการเปลี่ยนแปลงได้ดี เน้นทำงานร่วมกับลูกค้า\n• Scrum: เฟรมเวิร์กยอดนิยมของ Agile มีการแบ่งรอบการทำงานเป็นรอบสั้นๆ เรียกว่า 'Sprint' (มักใช้เวลา 1-4 สัปดาห์) มีบทบาท: Product Owner, Scrum Master, Development Team\n• DevOps (Development + Operations): วัฒนธรรมและการประสานงานระหว่างทีมพัฒนาและทีมดูแลระบบ เน้น CI/CD (Continuous Integration / Continuous Deployment) เพื่อส่งมอบงานได้รวดเร็วและต่อเนื่อง"
    ],
    [
        'title' => "ประเภทคำสั่งภาษา SQL (Structured Query Language)",
        'content' => "คำสั่ง SQL แบ่งออกเป็น 4 กลุ่มหลัก:\n1. DDL (Data Definition Language) - จัดการโครงสร้างฐานข้อมูล:\n   - CREATE (สร้างตาราง/ฐานข้อมูล), ALTER (แก้ไขโครงสร้าง), DROP (ลบตารางทิ้งทั้งโครงสร้าง), TRUNCATE (ล้างข้อมูลทั้งหมดในตารางแต่โครงสร้างยังอยู่)\n2. DML (Data Manipulation Language) - จัดการข้อมูลภายในตาราง:\n   - SELECT (ดึงข้อมูล), INSERT (เพิ่มข้อมูลใหม่), UPDATE (แก้ไขข้อมูลเดิม), DELETE (ลบข้อมูลบางแถว)\n3. DCL (Data Control Language) - ควบคุมสิทธิ์การเข้าถึงข้อมูล:\n   - GRANT (ให้สิทธิ์), REVOKE (เพิกถอนสิทธิ์)\n4. TCL (Transaction Control Language) - จัดการทรานแซกชัน:\n   - COMMIT (บันทึกการเปลี่ยนแปลงถาวร), ROLLBACK (ยกเลิกและย้อนกลับการเปลี่ยนแปลง), SAVEPOINT (สร้างจุดบันทึกชั่วคราว)"
    ],
    [
        'title' => "คุณสมบัติของฐานข้อมูล (ACID Properties) & Normalization",
        'content' => "คุณสมบัติ ACID ของระบบฐานข้อมูล (RDBMS):\n• Atomicity (ความเป็นหนึ่งเดียว): งานในทรานแซกชันต้องสำเร็จทั้งหมด ถ้าจุดใดผิดพลาดต้องย้อนกลับทั้งหมด (All or Nothing)\n• Consistency (ความถูกต้องสอดคล้อง): ข้อมูลต้องถูกต้องตามกฎเกณฑ์และเงื่อนไข (Constraints) ของระบบเสมอ\n• Isolation (ความเป็นอิสระ): ทรานแซกชันที่เกิดขึ้นพร้อมกันต้องไม่รบกวนกัน เสมือนทำงานทีละรายการ\n• Durability (ความคงทนถาวร): เมื่อ Commit แล้ว ข้อมูลต้องคงอยู่อย่างถาวรแม้ระบบจะไฟดับหรือล่มในทันที\n\nNormalization (การลดความซ้ำซ้อนของข้อมูล):\n- 1NF: แต่ละคอลัมน์ต้องเก็บค่าที่เป็นเชิงเดี่ยว (Atomic value) ไม่มีกลุ่มข้อมูลซ้ำ (Repeating groups)\n- 2NF: ต้องอยู่ใน 1NF และทุกคอลัมน์ที่ไม่ใช่คีย์หลักต้องขึ้นกับ Primary Key ทั้งหมด (No Partial Dependency)\n- 3NF: ต้องอยู่ใน 2NF และไม่มีการขึ้นต่อกันแบบทอดต่อกันระหว่างฟิลด์ที่ไม่ใช่คีย์ (No Transitive Dependency)"
    ],
    [
        'title' => "HTTP Methods, RESTful API และ HTTP Status Codes",
        'content' => "HTTP Methods สำหรับ RESTful API (CRUD):\n• GET: ดึงข้อมูล (Read)\n• POST: สร้างข้อมูลใหม่ (Create)\n• PUT: แก้ไขข้อมูลเดิมทั้งก้อน (Update/Replace)\n• PATCH: แก้ไขข้อมูลเดิมเฉพาะบางฟิลด์ (Partial Update)\n• DELETE: ลบข้อมูล (Delete)\n\nHTTP Status Codes ที่พบบ่อย:\n• 2xx (สำเร็จ):\n  - 200 OK: สำเร็จทั่วไป\n  - 201 Created: สร้างข้อมูลใหม่สำเร็จ\n• 3xx (การเปลี่ยนเส้นทาง):\n  - 301 Moved Permanently: ย้าย URL ถาวร\n  - 304 Not Modified: ข้อมูลไม่เปลี่ยนแปลง ดึงจากแคชได้\n• 4xx (ความผิดพลาดฝั่งไคลเอนต์):\n  - 400 Bad Request: ส่งข้อมูลคำขอไม่ถูกต้อง\n  - 401 Unauthorized: ยังไม่ได้เข้าสู่ระบบ (ต้องยืนยันตัวตน)\n  - 403 Forbidden: เข้าสู่ระบบแล้วแต่ไม่มีสิทธิ์เข้าถึงทรัพยากรนี้\n  - 404 Not Found: ไม่พบหน้าเว็บหรือทรัพยากรที่ร้องขอ\n• 5xx (ความผิดพลาดฝั่งเซิร์ฟเวอร์):\n  - 500 Internal Server Error: เซิร์ฟเวอร์ทำงานผิดพลาด\n  - 502 Bad Gateway: เกตเวย์ทำงานขัดข้อง\n  - 503 Service Unavailable: เซิร์ฟเวอร์ทำงานหนักหรือปิดปรับปรุงชั่วคราว"
    ],
    [
        'title' => "รูปแบบบริการ Cloud Computing: IaaS, PaaS, SaaS",
        'content' => "• IaaS (Infrastructure as a Service): ผู้ให้บริการเตรียมฮาร์ดแวร์ เครือข่าย สตอเรจ และ Virtual Machine ให้ ผู้ใช้ต้องลง OS และติดตั้งโปรแกรมเอง (เช่น AWS EC2, Google Compute Engine, Azure VM)\n• PaaS (Platform as a Service): ผู้ให้บริการเตรียมระบบปฏิบัติการ ฐานข้อมูล และรันไทม์ไว้ให้ ผู้ใช้มีหน้าที่พัฒนาโค้ดและแอปพลิเคชันอย่างเดียว (เช่น Heroku, Google App Engine, AWS Elastic Beanstalk)\n• SaaS (Software as a Service): ซอฟต์แวร์สำเร็จรูปพร้อมใช้งานผ่านเว็บเบราว์เซอร์ ผู้ใช้ไม่ต้องจัดการโครงสร้างพื้นฐานใดๆ (เช่น Microsoft 365, Google Workspace, Gmail, Canva, Salesforce)\n\nรูปแบบการติดตั้งคลาวด์ (Cloud Deployment):\n- Public Cloud: ให้บริการแก่บุคคลทั่วไปผ่านอินเทอร์เน็ตสาธารณะ\n- Private Cloud: ใช้งานเฉพาะภายในองค์กรเดี่ยวเพื่อความปลอดภัยสูงสุด\n- Hybrid Cloud: ผสมผสานระหว่าง Private Cloud และ Public Cloud เข้าด้วยกัน"
    ],
];
