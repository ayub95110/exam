<?php
// สรุปเน็ตเวิร์ก พอร์ต และความมั่นคงปลอดภัยไซเบอร์ ภาค ข.
return [
    [
        'title' => "เปรียบเทียบ OSI Model 7 Layers vs TCP/IP Model",
        'content' => "OSI Model (7 เลเยอร์) [จำง่ายๆ: All People Seem To Need Data Processing]:\n7. Application: อินเทอร์เฟซผู้ใช้ (HTTP, HTTPS, FTP, DNS, SMTP)\n6. Presentation: เข้ารหัส แปลงรูปแบบ บีบอัดข้อมูล (SSL/TLS, ASCII, JPEG)\n5. Session: จัดการและควบคุมเซสชันการเชื่อมต่อ (RPC, NetBIOS)\n4. Transport: ส่งข้อมูลระหว่างปลายทาง (TCP ควบคุมลำดับและรับประกัน, UDP เน้นเร็ว) [PDU: Segment]\n3. Network: หาเส้นทางและกำหนดแอดเดรส منطقي (IP, ICMP, Router) [PDU: Packet]\n2. Data Link: ควบคุมการส่งผ่านสาย มี Physical Address (Ethernet, MAC Address, Switch) [PDU: Frame]\n1. Physical: สัญญาณไฟฟ้า คลื่น แสง (สาย CAT6, Fiber Optic, Hub, Repeater) [PDU: Bit]\n\nTCP/IP Model (4 เลเยอร์): Application -> Transport -> Internet -> Network Access"
    ],
    [
        'title' => "ตารางหมายเลข Port มาตรฐานที่ออกสอบบ่อยที่สุด (Well-Known Ports)",
        'content' => "• Port 20, 21: FTP (File Transfer Protocol) - โอนย้ายไฟล์ (20=Data, 21=Control)\n• Port 22: SSH (Secure Shell) / SFTP - รีโมตคอนโซลแบบเข้ารหัสความปลอดภัยสูง\n• Port 23: Telnet - รีโมตคอนโซลแบบไม่เข้ารหัส (ส่งข้อมูลเป็น Plain Text)\n• Port 25: SMTP (Simple Mail Transfer Protocol) - ส่งอีเมลระหว่างเซิร์ฟเวอร์\n• Port 53: DNS (Domain Name System) - แปลง Domain Name เป็น IP Address (UDP/TCP)\n• Port 67, 68: DHCP (Dynamic Host Configuration Protocol) - แจกจ่าย IP อัตโนมัติ (67=Server, 68=Client)\n• Port 80: HTTP (Hypertext Transfer Protocol) - เว็บไซต์แบบไม่เข้ารหัส\n• Port 110: POP3 (Post Office Protocol v3) - ดึงอีเมลมาเก็บที่เครื่อง\n• Port 143: IMAP (Internet Message Access Protocol) - ซิงค์อีเมลบนเซิร์ฟเวอร์\n• Port 161: SNMP (Simple Network Management Protocol) - ตรวจสอบอุปกรณ์เครือข่าย\n• Port 443: HTTPS (HTTP Secure) - เว็บไซต์เข้ารหัสผ่าน SSL/TLS\n• Port 3306: MySQL / MariaDB Database\n• Port 1433: Microsoft SQL Server (MSSQL)\n• Port 3389: RDP (Remote Desktop Protocol) - รีโมตหน้าจอ Windows"
    ],
    [
        'title' => "ระบบ IP Address และ Subnetting",
        'content' => "• IPv4: ขนาด 32 บิต แบ่งเป็น 4 กลุ่ม กลุ่มละ 8 บิต (Octet) คั่นด้วยจุด (เช่น 192.168.1.1) มี 4.3 พันล้านเบอร์\n• IPv6: ขนาด 128 บิต แบ่งเป็น 8 กลุ่ม กลุ่มละ 16 บิต เขียนด้วยเลขฐานสิบหก คั่นด้วยโคลอน (:)\n• Private IP Address (ช่วงไอพีที่ใช้ภายใน ไม่ถูก Route บนอินเทอร์เน็ตสาธารณะ):\n  - Class A: 10.0.0.0 ถึง 10.255.255.255 (/8)\n  - Class B: 172.16.0.0 ถึง 172.31.255.255 (/12)\n  - Class C: 192.168.0.0 ถึง 192.168.255.255 (/16)\n• Loopback Address: 127.0.0.1 (IPv4) หรือ ::1 (IPv6) ใช้ทดสอบเครือข่ายภายในเครื่องตนเอง\n• APIPA (Automatic Private IP): 169.254.x.x (เกิดขึ้นเมื่อเครื่องขอ IP จาก DHCP ไม่สำเร็จ)\n• MAC Address: ขนาด 48 บิต (6 ไบต์) เขียนด้วยเลขฐานสิบหก เป็นฮาร์ดแวร์แอดเดรสประจำการ์ดแลน"
    ],
    [
        'title' => "เสาหลักความมั่นคงปลอดภัยสารสนเทศ: CIA Triad และ AAA",
        'content' => "CIA Triad:\n1. Confidentiality (การรักษาความลับ): ป้องกันไม่ให้ผู้ไม่มีสิทธิ์เข้าถึงข้อมูลได้ (ป้องกันด้วยการเข้ารหัส Encryption, Access Control, MFA)\n2. Integrity (ความถูกต้องแท้จริง): ป้องกันการแก้ไขหรือปลอมแปลงข้อมูลโดยไม่ได้รับอนุญาต (ป้องกันด้วย Hashing, Digital Signature, Checksum)\n3. Availability (ความพร้อมใช้งาน): ระบบและข้อมูลต้องพร้อมใช้งานเมื่อต้องการเสมอ (ป้องกันด้วย Redundancy, Backup, Load Balancing, DDoS Protection, UPS)\n\nโมเดล AAA:\n- Authentication (การพิสูจน์ตัวตน): คุณคือใคร? (Username/Password, OTP, สแกนลายนิ้วมือ)\n- Authorization (การกำหนดสิทธิ์): คุณมีสิทธิ์ทำอะไรได้บ้าง? (Role-Based Access Control, Permission)\n- Accounting / Auditing (การบันทึกและตรวจสอบ): คุณทำอะไรไปบ้าง เมื่อไหร่? (Log File, Audit Trail)"
    ],
    [
        'title' => "สรุปรูปแบบการโจมตีทางไซเบอร์ที่พบบ่อย (Cyber Attacks)",
        'content' => "• Phishing: การหลอกลวงผ่านอีเมลหรือหน้าเว็บปลอมเพื่อขโมยข้อมูลลับ รหัสผ่าน บัตรเครดิต\n• Ransomware (มัลแวร์เรียกค่าไถ่): เข้ารหัสไฟล์ในเครื่องเหยื่อและขู่กรรโชกเงินเพื่อแลกคีย์ถอดรหัส\n• DDoS (Distributed Denial of Service): การระดมส่งทราฟฟิกมหาศาลจาก Botnet หลายพันเครื่องจนเซิร์ฟเวอร์ล่ม\n• SQL Injection (SQLi): การแทรกคำสั่ง SQL อันตรายลงในฟอร์มรับข้อมูลเพื่อดึงข้อมูลลับหรือทำลายฐานข้อมูล\n• Cross-Site Scripting (XSS): การฝังโค้ด JavaScript อันตรายลงบนหน้าเว็บเพื่อขโมย Cookie/Session ของผู้ใช้\n• Man-in-the-Middle (MitM): การดักฟังและแอบแก้ไขข้อมูลระหว่างผู้ใช้กับเซิร์ฟเวอร์ (ป้องกันได้ด้วย HTTPS)\n• Social Engineering (วิศวกรรมสังคม): การหลอกลวงและโน้มน้าวใจมนุษย์ให้เปิดเผยรหัสผ่านหรือความลับองค์กร\n• Zero-Day Vulnerability: ช่องโหว่ของซอฟต์แวร์ที่เพิ่งถูกค้นพบและยังไม่มีแพตช์ (Patch) ป้องกันจากผู้พัฒนา"
    ],
];
