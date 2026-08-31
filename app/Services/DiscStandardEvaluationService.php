<?php

namespace App\Services;

class DiscStandardEvaluationService
{
    /**
     * 40 Standard DISC Personality Patterns from Official Standard DISC Software 2018 (Def Sheet).
     */
    protected array $patterns = array (
  1 => 
  array (
    'index' => 1,
    'code' => 'C',
    'title' => 'LOGICAL THINKER',
    'traits' => 
    array (
      0 => 'Pendiam',
      1 => 'Anti Kritik',
      2 => 'Perfeksionis',
      3 => 'Cenderung Santai',
      4 => 'Detail',
      5 => 'Empati',
      6 => 'Rapi',
      7 => 'Organized',
      8 => 'Kaku pada Metode & Prosedur',
    ),
    'suitable_jobs' => 'Planner (any function), Engineer (Installation, Technical), Technical/Research (Chemist Technician), Academic, Statistician, Government Worker, IT Management, Prison Officer, Quality Controller.',
    'description' => 'Seorang yang praktis, cakap dan unik. Ia orang yang mampu menilai diri sendiri dan kritis terhadap dirinya dan orang lain. Ia menyukai hal yang detil dan logis; secara alamiah ia sangat analitis. Karena menyimpan informasi, ia meneliti isu berulang-ulang kali. Ia cenderung malu dan tertutup; ia hati-hati dalam membuat keputusan yang berdasarkan pada logika, bukan emosi, selalu menggunakan pertanyaan "bagaimana dan mengapa". Ia mengerjakan sesuatu dengan sistematis dan akurat. Ia rapi dan terorganisir sebab ia merasa bahwa keadaan berantakan sama dengan mutu yang rendah; demikian juga, rapi dan teratur merupakan mutu yang tinggi. Sangat teliti dalam segala sesuatu seperti halnya dalam pekerjaan dan penggunaan waktunya. Ia merencanakan dan mengorganisir semua sisi kehidupannya. Kelambanan sangat mengganggunya dan tak dapat ditolerir.',
  ),
  2 => 
  array (
    'index' => 2,
    'code' => 'D',
    'title' => 'ESTABLISHER',
    'traits' => 
    array (
      0 => 'Individualis',
      1 => 'Ego Tinggi, Kurang Sensitif',
      2 => 'Kurang Pertimbangan',
      3 => 'Efektif',
      4 => 'High Motivation',
      5 => 'Bersemangat Tinggi',
      6 => 'Percaya Diri, cenderung Nekat',
      7 => 'Kreatif',
      8 => 'Terlalu Dominan',
      9 => 'Agresif',
      10 => 'Terlalu Dinamis',
      11 => 'Penuh Ambisi',
    ),
    'suitable_jobs' => 'Attorney, Researcher, Sales Representative, Planning Consultant, Transport Personnel, Production (Director, Manager, Supervisor), Technologist, Strategic Planning, Trouble Shooting, Marketing Services, Consultant, Engineering (Director, Manager, Supervisor) and Self-Employment.',
    'description' => 'Memiliki rasa ego yang tinggi dan cenderung invidualis dengan standard yang sangat tinggi. Ia lebih suka menganalisa masalah sendirian daripada bersama orang lain. Rasa egoisnya yang kuat membuatnya tidak nyaman di bawah kendali orang lain; ia lebih suka menjadi "boss" dan menetapkan standard tinggi baik untuk dirinya maupun orang lain. Ia menghindari sesuatu yang biasa-biasa dan cenderung mencari tantangan yang baru. Ia menyukai petualangan dan kadang-kadang beralih ke dalam petualangan baru sebelum mempertimbangkannya secara menyeluruh. Mampu memimpin situasi dan orang lain dalam rangka mencapai sasarannya; ia ingin selalu unggul dalam persaingan dengan taruhan apapun.',
  ),
  3 => 
  array (
    'index' => 3,
    'code' => 'D / C-D',
    'title' => 'DESIGNER',
    'traits' => 
    array (
      0 => 'Sensitif',
      1 => 'Kurang Cepat',
      2 => 'Anti Tekanan',
      3 => 'Terlalu Mandiri',
      4 => 'Kurang Percaya Orang Lain',
      5 => 'Anti Kritik',
      6 => 'Dingin',
      7 => 'Kreatif',
      8 => 'Result Oriented',
      9 => 'Suka Tantangan',
    ),
    'suitable_jobs' => 'Engineering (Management, Research, Design), Research (R&D), Planning, Chemist, Accountancy, Specialist, Finance, Technician, Quality Control, Production Planning/Management, Design Engineer, Bookkeeper, Chemist Technician, Safety Officer, Librarian.',
    'description' => 'Seorang yang sangat berorientasi pada tugas dan sensitif pada permasalahan. Ia lebih mempedulikan tugas yang ada dibanding orang-orang di sekitarnya, termasuk perasaan mereka. Sangat kukuh/keras dan mempunyai pendekatan yang efektif dalam pemecahan masalah. Oleh karena sifat alamiah dan keinginannya akan hasil yang terukur, Akan tampak dingin, tidak berperasaan dan menjaga jarak. Ia membuat keputusan berdasar pada fakta, bukan emosi. Cenderung pendiam dan tidak mudah percaya.',
  ),
  4 => 
  array (
    'index' => 4,
    'code' => 'D / I-D',
    'title' => 'NEGOTIATOR',
    'traits' => 
    array (
      0 => 'Suka Bergaul',
      1 => 'Anti Rutin',
      2 => 'Aktif',
      3 => 'Terlalu Percaya Diri',
      4 => 'Agresif',
      5 => 'Optimis',
      6 => 'Kurang Detail',
      7 => 'Result Oriented',
    ),
    'suitable_jobs' => 'Sales and Marketing (Directing, Manager, Person), Public Relations, Recruitment Consultant, Politician, Director, Self-Employed, Hotelier, Travel Agent, Trainer, Hospitality, Lawyer, Solicitor, Motivators, Team Leader, Politician, Trainer, Lecturer, Theatrical Agent, General Management and Leading People, Attorney.',
    'description' => 'Merupakan seorang pemimpin integratif yang bekerja dengan dan melalui orang lain.  Ia ramah, memiliki perhatian yang tinggi akan orang dan juga mempunyai kemampuan untuk memperoleh hormat dan penghargaan dari berbagai tipe orang.  Melakukan pekerjaannya dengan cara yang bersahabat, baik dalam mencapai sasarannya maupun meyakinkan pandangannya kepada orang lain.  Ia tidak begitu memperhatikan hal-hal kecil.  Kadang bertindak sesuai dengan kata hati/impulsif, terlalu antusias dan sangat banyak bicara.  Ia terlalu berlebihan menilai kemampuannya dalam memotivasi atau mengubah perilaku orang lain.  Mencari kebebasan dari rutinitas, menginginkan otoritas/wewenang dan juga prestise.  Ia menginginkan aktivitas yang bervariasi dan bekerja lebih efisien jika data-data analitis disediakan oleh orang lain.  Menginginkan penugasan yang mengutamakan mobilitas dan tantangan.',
  ),
  5 => 
  array (
    'index' => 5,
    'code' => 'D / I-D-C',
    'title' => 'CONFIDENT & DETERMINED',
    'traits' => 
    array (
      0 => 'Pandai Memilih Orang',
      1 => 'Leader',
      2 => 'Good Interpersonal Skill',
      3 => 'Dominan',
      4 => 'Agresif',
      5 => 'Perfeksionis',
      6 => 'Good Communication Skill',
      7 => 'Aktif',
      8 => 'Need Recognition n Reward',
      9 => 'Kurang Peduli pada Aturan',
      10 => 'Terburu-buru',
    ),
    'suitable_jobs' => 'Specialist/Technical Selling (Computer, Finance, Engineer and others, Chef, Technical/Capital Equipment Selling), Financial (Manager, Specialist), Computer Hardware Sales, Engineering (Manager, Designer, Buyer, Draughtsman), Project Engineer, Sales Engineer, Consultant, Trainer, Lecturer, Hotelier, Insurance, Mortgage and Finance Sales, Teacher, Travel Agent, Personnel and Marketing Services.',
    'description' => 'Sangat berorientasi terhadap tugas dan juga menyukai orang.  Ia sangat baik dalam menarik orang/recruiting.  Seorang yang bersahabat, tetapi menyukai keadaan di mana tugas-tugas harus dilakukan dengan benar.  Ia kadang-kadang tampak dingin dan mendominasi.  Ia juga bisa sangat fokus pada tugas dan melupakan orang-orang di sekitarnya.  Sangat mengharapkan orang-orang terlibat dalam proyeknya, tetapi tidak memperdulikan apa yang diinginkan oleh orang-orang itu.  Ia perlu mendengar dan memikirkan  apa yang menjadi keinginan orang di sekitarnya, khususnya kesempatan untuk mencoba.  Ia sangat membutuhkan persetujuan sosial seperti halnya ia sangat mempercayai orang lain.  Karena itu, ia kadang-kadang berlebihan dalam menilai orang dan kemampuannya.  Ia tampak tidak konsisten dan tidak karuan karena ketidakmampuannya berkonsentrasi dan fokus dalam waktu yang lama.  Perlu belajar untuk secara sungguh-sungguh mendengarkan orang-orang di sekitarnya dari pada selalu berpikir apa yang ingin dikatakan.  Ia mempunyai kemampuan logika yang tinggi ketika ia mau menggunakannya.',
  ),
  6 => 
  array (
    'index' => 6,
    'code' => 'D / I-D-S',
    'title' => 'REFORMER',
    'traits' => 
    array (
      0 => 'Mudah Bergaul',
      1 => 'Leader',
      2 => 'Sadar Diri',
      3 => 'Butuh Pujian & Penghargaan',
      4 => 'Cepat Percaya Orang',
      5 => 'Mudah Simpati & Empati',
      6 => 'Motivator',
      7 => 'Optimis & Positif',
      8 => 'Anti Aturan',
      9 => 'Kurang Detail',
      10 => 'Terlalu Selektif',
    ),
    'suitable_jobs' => 'Hotelier, Customer Service, Complaints Manager, Recruiting Agent, Sales (Manager/Person), Marketing Services, Public Relations, Politician, Computer Software Sales, Lecturer, Engineering and Production (Manager/Supervisor).',
    'description' => 'Seorang yang bersahabat dan sosial; ia juga suka mengendalikan situasi dan menjadi pemimpin.  Ia menyelesaikan tugasnya melalui keterampilan sosialnya; ia peduli dan menerima orang lain.  Ia berkonsentrasi pada tugas yang ada di tangannya sampai selesai dan akan minta bantuan orang lain jika perlu.  Ia menyadari keterbatasannya dan meminta bantuan jika memerlukannya.  Ia disukai dan orang ingin menolongnya.  Senang membagi kebanggaannya dengan kelompok; ia seorang team player tetapi juga team leader.  Menginginkan popularitas dan pengakuan.',
  ),
  7 => 
  array (
    'index' => 7,
    'code' => 'D / I-S-D',
    'title' => 'MOTIVATOR',
    'traits' => 
    array (
      0 => 'Leader (Kelompok Kecil)',
      1 => 'Supporter',
      2 => 'Sosialisasi Baik',
      3 => 'Butuh Ketegasan',
      4 => 'Butuh Pujian & Penghargaan',
      5 => 'Kurang Detail',
      6 => 'Agak Kaku',
    ),
    'suitable_jobs' => 'Hotelier, Community Counseling, Customer Service, Complaints Manager, Community Work, Recruitment Consultant, Hospitality, Teacher, Telemarketing, Production Manager, Complaints Manager, Recruiting Agent, Sales (Manager/Person), Marketing Services, Public Relations, Politician, Call Centre Manager, Lecturer, Engineering and Production (Manager/Supervisor).',
    'description' => 'Seorang yang menampilkan gaya bersemangat ketika termotivasi pada sasaran.  Ia lebih suka memimpin atau melibatkan diri, walaupun ia juga mau melayani sebagai pembantu.  Ia membutuhkan pengakuan dan penghargaan serta senang pada peran pendukung.  Ia peduli kepada orang-orang di sekitarnya dan akan mempertimbangkan perasaan orang lain dalam proses pengambilan keputusan.  Menampilkan keterampilan berhubungan dan berkomunikasi dengan sangat baik.  Ia akan berusaha keras menyelesaikan tugas dengan cepat dan efisien.',
  ),
  8 => 
  array (
    'index' => 8,
    'code' => 'D / S-D-C / S-C-D',
    'title' => 'INQUIRER',
    'traits' => 
    array (
      0 => 'Full Self Control',
      1 => 'Sabar',
      2 => 'Penuh Pertimbangan',
      3 => 'Good Interpersonal',
      4 => 'Selektif',
      5 => 'Lambat Adaptasi',
      6 => 'Inisiatif kurang',
      7 => 'Result Oriented',
      8 => 'Kaku dan Keras Kepala',
      9 => 'Good Service',
      10 => 'Kurang dlm hal Managerial',
    ),
    'suitable_jobs' => 'Directing, Managing or Supervising (in Engineering, Accountancy, Research and Development and Computing disciplines), Research Manager, Scientific Work, Accountant, Administration, Project Engineer, Draughtsman, Designer, Analyst, Finance, Chemist, Technical Service Support, Flight Attendant, Technician, Service Engineer, Service Manager, Security Specialist.',
    'description' => 'Seorang yang sabar, terkontrol dan suka menggali fakta dan jalan keluar.  Ia tenang dan ramah.  Ia merencanakan pekerjaan dengan hati-hati, tetapi agresif, menanyakan sesuatu serta mengumpulkan data pendukung.  Kemudian ia bekerja dengan konsisten dengan arahan yang benar.  Menjadi individu yang penuh perhatian, rendah hati, dan ia berhubungan baik dengan hampir semua orang.  Seorang yang konsisten dan suka menolong. People skill darinya melebihi orientasi tugasnya.',
  ),
  9 => 
  array (
    'index' => 9,
    'code' => 'D-I',
    'title' => 'PENGAMBIL KEPUTUSAN',
    'traits' => 
    array (
      0 => 'Pekerja Keras',
      1 => 'Leader',
      2 => 'Banyak Minat',
      3 => 'Dingin / Task Oriented',
      4 => 'Kurang Pergaulan',
      5 => 'Kontrol Emosi Kurang',
      6 => 'Suka Tantangan',
      7 => 'Cepat Bosan',
      8 => 'Anti Aturan',
      9 => 'Kurang Detail',
      10 => 'Kurang Peduli Wewenang',
      11 => 'Argumentatif',
    ),
    'suitable_jobs' => 'General Management (Directing/Managing/Supervising, Public Relations, Business Management, Conflict Resolution, Industrial Relations, Business Consultant, Trouble Shooting, Sales and Sales Management, Marketing, Promoting, Production (Director, Manager, Supervisor), Consultancy, Publishing, Sales Executive, Promotional Work, Brokers, Self-Employment, Advertising, Lecturing, Dealing/Broking.',
    'description' => 'Tidak basa-basi dan tegas, ia cenderung merupakan seorang invidualis yang kuat. Ia berpandangan jauh ke depan, progresif dan mau berkompetisi untuk mencapai sasaran. DI seorang yang selalu ingin tahu dan mempunyai minat dengan cakupan yang luas. Ia seorang yang logis, kritis dan tajam dalam memecahkan masalah. Sering kali ia tampak imajinatif. Ia mempunyai kemampuan memimpinan yang baik. Ia kadang tampak keras kepala atau dingin karena orientasi dan prioritasnya pada tugas cenderung melebihi orientasi terhadap sesama. Ia mencanangkan standard tinggi pada dirinya dan akan sangat kritis ketika standard ini tidak dicapai. Ia juga menempatkan standard tinggi pada orang-orang di sekitarnya, serta mengutamakan kesempurnaan. Ia menginginkan otoritas yang jelas dan menyukai tugas-tugas baru.',
  ),
  10 => 
  array (
    'index' => 10,
    'code' => 'D-I-S',
    'title' => 'DIRECTOR',
    'traits' => 
    array (
      0 => 'Pengelola',
      1 => 'Enerjik',
      2 => 'Kurang Detail',
      3 => 'Mudah Bosan',
      4 => 'Agresif',
      5 => 'Arogan',
      6 => 'Kurang Focus',
    ),
    'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Office Management, Account Manager, Customer Service, Retail Manager, IT, Lecturer, Logistics, Manager-General, National Accounts Manager, Teacher, Projects Manager.',
    'description' => 'Fokus pada penyelesaian pekerjaan dan menunjukkan penghargaan yang tinggi kepada orang lain.  Ia memiliki kemampuan untuk menggerakkan orang dan pekerjaan dikarenakan keterampilannya berpikir ke depan dan hubungan antar manusia.  Tidak berorientasi detil, ia fokus pada target secara keseluruhan dengan menyerahkan hal detil kepada orang lain.  Enerjik dan sosial, ia mampu memotivasi orang lain sambil menyelesaikan pekerjaannya.  Ia menampilkan rasa percaya diri dan mampu meyakinkan orang lain.  Sekali ia memutuskan sesuatu, ia akan terus mengerjakannya dan bertahan sampai selesai.',
  ),
  11 => 
  array (
    'index' => 11,
    'code' => 'D-S',
    'title' => 'SELF-MOTIVATED',
    'traits' => 
    array (
      0 => 'Objektif & Analitis',
      1 => 'Mandiri',
      2 => 'Good Planner',
      3 => 'Komitmen thd Target',
      4 => 'Menghindari Konflik',
    ),
    'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Project Management, Researcher, Chemist (R&D), Planner, Engineering (R&D), Systems Analyst, Commercial Planner, Computer Engineer, Programmer, IT, Other computer-related disciplines, Technical Trouble Shooting and Directing, Lawyer, Solicitor, Development Engineer, Work Study, Barrister, Attorney.',
    'description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
  ),
  12 => 
  array (
    'index' => 12,
    'code' => 'I / C-I-S',
    'title' => 'MEDIATOR',
    'traits' => 
    array (
      0 => 'Loyal',
      1 => 'Tight Scheduled',
      2 => 'Curious',
      3 => 'Sensitif',
      4 => 'Good Communication Skill',
      5 => 'Good Analitical Think',
      6 => 'Good Interpersonal Skill',
      7 => 'Cepat Beradaptasi',
      8 => 'Anti Kritik',
      9 => 'Not Leader',
      10 => 'Work/Play Conflict',
    ),
    'suitable_jobs' => 'Engineering and Production (Supervisor, Installer, Technician, Service and Design), Research (Supervisor, Chemist, Lab. Technician), Trainer, Finance (Supervisor, Accountant, Advisor), Public Relations, Administration, Office Administrator, Market Analyst, System Analyst, Programmer, Selling (Technical/Service).',
    'description' => 'Merupakan individu yang berorientasi pada orang, ia mampu menggabungkan ketepatan dan loyalitas.  Ia cenderung peka dan mempunyai standard yang tinggi.  Ia menginginkan stabilitas dan berorientasi terhadap sasaran.  Ia menginginkan pengakuan sosial dan perhatian pribadi.  Ia bersahabat, antusias, informal, banyak bicara, dan mungkin sangat mencemaskan apa yang dipikirkan oleh orang lain.  Ia menolak agresi, dan mengharapkan suasana harmonis.  Ia cenderung cukup cerdas dalam berbagai hal. Ia merupakan pencari fakta yang sangat baik dan akan membuat keputusan yang baik setelah mengumpulkan fakta dan data pendukung.',
  ),
  13 => 
  array (
    'index' => 13,
    'code' => 'I / C-S-I',
    'title' => 'PRACTITIONER',
    'traits' => 
    array (
      0 => 'Perfeksionis',
      1 => 'Quality Oriented',
      2 => 'Scheduled',
      3 => 'Anti Kejutan',
      4 => 'Good Interpersonal Skill',
      5 => 'Terlalu Detail',
      6 => 'Sistematis',
      7 => 'Kaku / Tidak fleksibel',
      8 => 'Monoton',
    ),
    'suitable_jobs' => 'Engineering and Production (Supervisor, Installer, Technician, Service and Design), Research (Supervisor, Chemist), Trainer, Finance (Manager, Supervisor, Accountant, Advisor), Public Relations-Administration, Purchasing, Chemist Research, Office Administrator, Computer Programmer, Market Analyst, System Analyst, Programmer, Research and Development Supervisor, Laboratory Technician, Legal, Selling (Technical/Service).',
    'description' => 'Merupakan individu yang berorientasi pada orang, ia mampu menggabungkan ketepatan dan loyalitas.  Ia cenderung peka dan mempunyai standard yang tinggi.  Ia menginginkan stabilitas dan berorientasi terhadap sasaran.  Ia menginginkan pengakuan sosial dan perhatian pribadi.  Bersahabat, antusias, informal, banyak bicara, dan mungkin sangat mencemaskan apa yang dipikirkan oleh orang lain.  Ia menolak agresi dan mengharapkan suasana harmonis.  Ia cenderung cukup cerdas dalam berbagai hal. Ia merupakan pencari fakta yang sangat baik dan akan membuat keputusan yang baik setelah mengumpulkan fakta dan data pendukung.',
  ),
  14 => 
  array (
    'index' => 14,
    'code' => 'I-S-C / I-C-S',
    'title' => 'RESPONSIVE & THOUGHTFUL',
    'traits' => 
    array (
      0 => 'High Energy',
      1 => 'Good Communication Skill',
      2 => 'To The Point',
      3 => 'Sensitif',
      4 => 'Banyak Bicara',
      5 => 'Need Recognation',
      6 => 'Need Socialism',
      7 => 'Anti thd Kritik',
      8 => 'Terlalu banyak bersosialisasi',
      9 => 'Leadership kurang',
      10 => 'Kurang Fokus',
      11 => 'Anti Deadline',
    ),
    'suitable_jobs' => 'Actors, Chef, Personnel, Welfare, Broadcasting, Training, Attorney, Teaching, Accounting, Technical Instructor, Accounting-General, Accounts Supervisor, Customer Services, Public Relations, Artist, Hotelier, Demonstrator, Florist/Floral Designer, Engineering (Sales, Service, Project, Draughtsman, Designer), Graphic Designer, Specialist (Soft/Services), Selling, Purchasing, Singers, Technical Instructor, Personnel Management, Politician, Supervising (Engineering, Production, Accounts), Administration Work, Sales Engineer, Secretarial, Industrial Relations Specialist.',
    'description' => 'Merupakan individu yang berorientasi pada orang dan lancar berkomunikasi serta loyal.  Ia cenderung sensitif dan mempunyai standard yang tinggi.  Keputusannya dibuat berdasarkan fakta dan data pendukung.  Ia sepertinya tidak bisa diam.  Ia perlu untuk lebih terus terang dan jangan terlalu subyektif.  Ia butuh pengakuan sosial dan perhatian pribadi; ia dapat cepat akrab dengan orang lain.  Ia bersahabat, antusias, informal, banyak bicara dan terlalu khawatir terhadap apa yang dipikirkan orang.  Ia menguasai banyak hal.  Ia ingin diterima sebagai anggota kelompok dan ingin mengetahui secara pasti apa yang diharapkan darinya sebelum ia memulai proyek baru.',
  ),
  15 => 
  array (
    'index' => 15,
    'code' => 'S',
    'title' => 'SPECIALIST',
    'traits' => 
    array (
      0 => 'Stabil & Konsisten',
      1 => 'Terkendali',
      2 => 'Nyaman di Belakang Layar',
      3 => 'Sabar',
      4 => 'Loyal',
      5 => 'Sulit Adaptasi',
      6 => 'Process Oriented',
      7 => 'Teguh',
      8 => 'Need for Peace',
      9 => 'Anti Perubahan',
      10 => 'Sulit Menentukan Prioritas',
    ),
    'suitable_jobs' => 'Administrative Work, Engineering and Production areas (Sales, Services, Project, Painter, Plumber, Draughtsman, Designer, Operative), Chef, Accounting, Telemarketing/Tele-Sales, Research and Development, Administrator, Florist/Floral Designer, Retail-General, Sales-General, Accounting-General, Service-General, Landscape Gardener.',
    'description' => 'Merupakan individu konsisten yang berusaha menjaga lingkungan/suasana yang tidak berubah.  Ia bekerja dengan baik bersama orang-orang dengan berbagai kepribadian karena perilakunya yang terkendali dan rendah hati.  Sabar, loyal dan suka menolong.  Persahabatan dikembangkannya dengan lambat dan selektif.  Ia tidak bosan dengan rutinitas dan sangat baik bekerja dengan petunjuk dan peraturan yang jelas. Ia mengharapkan bantuan dan supervisi pada saat mengawali proyek baru.  Ia butuh waktu untuk menyesuaikan diri dengan perubahan dan sungkan menjalankan "cara-cara lama mengerjakan sesuatu".  Ia akan menghindari konfrontasi dan berusaha sekuat tenaga memendam perasaannya.',
  ),
  16 => 
  array (
    'index' => 16,
    'code' => 'S / C-S',
    'title' => 'PERFECTIONIST',
    'traits' => 
    array (
      0 => 'Detail & Teliti',
      1 => 'Butuh Situasi Stabil',
      2 => 'Sistematik & Prosedural',
      3 => 'Menghindari Konflik',
      4 => 'Anti Kritik',
      5 => 'Lambat Memutuskan',
      6 => 'Sulit Adaptasi',
      7 => 'Pendendam',
      8 => 'Anti Perubahan',
    ),
    'suitable_jobs' => 'Researcher (Technician, Chemist, Quality Control), Engineer (Project, Draughtsman, Armed Forces, Designer), Statistician, Surveyor, Optician, Medical Specialist, Health Care, IT Management, Planner, Technical Writing, Production, Dentist, Quality Control, Planning, Dental Technician, Accounting, Computer Programmer, Psychologist, Surgeon, Architect, Medical Specialist.',
    'description' => 'Berpikir sistematis dan cenderung mengikuti prosedur dalam kehidupan pribadi dan pekerjaannya.  Teratur dan memiliki perencanaan yang baik, ia teliti dan fokus pada detil.  Bertindak dengan penuh kebijaksanaan, diplomatis dan jarang menentang rekan kerjanya dengan sengaja.  Ia sangat berhati-hati, sungguh-sungguh mengharapkan akurasi dan standard tinggi dalam pekerjaannya.  Ia cenderung terjebak dalam hal detil, khususnya jika harus memutuskan.  Menginginkan adanya petunjuk standard pelaksanaan kerja dan tanpa perubahan mendadak.',
  ),
  17 => 
  array (
    'index' => 17,
    'code' => 'S-C',
    'title' => 'PEACEMAKER, RESPECTFULL & ACCURATE',
    'traits' => 
    array (
      0 => 'Sulit Beradaptasi',
      1 => 'Anti Kritik',
      2 => 'Pendendam',
      3 => 'Sukar Berubah',
      4 => 'Detail',
      5 => 'Empati',
      6 => 'Memikirkan Dampak ke Orang Lain',
      7 => 'Terlalu Mendalam dalam Berpikir',
      8 => 'Concern ke Data dan Fakta',
      9 => 'Introvert',
      10 => 'Loyal',
    ),
    'suitable_jobs' => 'Office (Manager, Supervisor, Person), Chief Clerk, General Administrator, Production Supervisor, Planner, Accountant, Research and Development, Flight Attendant, Engineering (Project Manager, Supervisor, Technician), Computer Programmer, Draughtsman, Soft/Service Selling, Doctor, Cashier, Receptionist, Data Entry, Planner, Word Processing, Property Manager, Database Administrator, Health Care, Statistician, Nursing-Administration, Company Secretary, System Analyst, Programmer, Statistician, Accounting-General, Security Specialist.',
    'description' => 'Ia adalah orang yang baik secara alamiah dan sangat berorientasi detil.  Ia peduli dengan orang-orang di sekitarnya dan mempunyai kualitas yang membuatnya sangat teliti dalam penyelesaian tugas.  Ia mempertimbangkan sekelilingnya dengan hati-hati sebelum membuat keputusan untuk melihat pengaruhnya pada mereka; saat tertentu ia terlalu hati-hati.  Jika ia merasa seseorang memanfaatkan situasi, ia akan memperlambat kerjanya sehingga dapat mengamati apa yang sedang berlangsung di sekitarnya.',
  ),
  18 => 
  array (
    'index' => 18,
    'code' => 'D-C',
    'title' => 'CHALLENGER',
    'traits' => 
    array (
      0 => 'Seorang yang tekun',
      1 => 'Sensitif terhadap permasalahan',
      2 => 'Mempunyai keputusan yang kuat',
      3 => 'Kreatif  dalam memecahkan masalah',
      4 => 'Memiliki reaksi yang cepat',
      5 => 'Mampu mencari solusi permasalahan',
      6 => 'Banyak memberikan ide-ide.',
      7 => 'Usaha yang keras pada ketepatan',
      8 => 'Cenderung perfeksionis',
    ),
    'suitable_jobs' => 'Engineering (Management, Research, Design), Actuaries, Research (R&D), Planning, Chemist, Hospital Supervisor, Industrial Marketing, Investment Banking, Medical Administrator, Mortgage Brokers, Accountancy, Fund Management, Specialist Finance, Quality Control and Specialist work in any area where knowledge and experience is available, Production, Financial Services, Technical Management, Project Leader, Matron, Strategic Planning, Industrial Marketing.',
    'description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
  ),
  19 => 
  array (
    'index' => 19,
    'code' => 'D-I-C',
    'title' => 'CHANCELLOR',
    'traits' => 
    array (
      0 => 'Seorang yang ramah secara alami',
      1 => 'Menggabungkan kesenangan dengan pekerjaan',
      2 => 'Menyukai hubungan dengan sesama',
      3 => 'Menikmati interaksi dengan sesama',
      4 => 'Dapat mengerjakan hal-hal detil',
      5 => 'Ingin melakukan segala sesuatu dengan tepat',
      6 => 'Menilai orang dan tugas secara hati-hati',
      7 => 'Sering melalaikan perencanaan yang seksama',
      8 => 'Mudah beralih kepada proyek-proyek baru',
    ),
    'suitable_jobs' => 'Technical/Scientific (Directing, Management, Supervision), Engineering, Finance, Production Planning, Personnel Disciplines, Self-Employment, Credit Manager, Planner, Fund Management, Computer Hardware/Software Sales, IT, Business Consultant, Banking, Logistics, Lecturing, Work Study, Film Director, Transport, Consultancy, Industrial Relations and Computers (Selling, Software, Systems Analyst) and General Manager.',
    'description' => 'Ia menggabungkan antara kesenangan dengan pekerjaan/bisnis ketika melakukan sesuatu. Ia kelihatan menyukai hubungan dengan sesama tetapi juga dapat mengerjakan hal-hal detil. Ia ingin melakukan segala sesuatu dengan tepat, dan ia akan menyelesaikan tugasnya untuk meyakinkan ketepatan dan kelengkapannya. Seorang yang ramah secara alami dan menikmati interaksi dengan sesama, akan tetapi ia akan juga menilai orang dan tugas secara hati-hati; persahabatannya akan bergeser sesuai dengan dorongan hatinya pada orang lain di sekitarnya. Ia sering melalaikan perencanaan yang seksama dan akan beralih ke pada proyek-proyek baru tanpa pertimbangan yang menyeluruh.',
  ),
  20 => 
  array (
    'index' => 20,
    'code' => 'D-S-I',
    'title' => 'DIRECTOR',
    'traits' => 
    array (
      0 => 'Seorang yang obyektif dan analitis',
      1 => 'Ingin terlibat dalam situasi',
      2 => 'Ingin memberikan bantuan dan dukungan',
      3 => 'Termotivasi oleh target pribadi',
      4 => 'Berorientasi terhadap pekerjaannya',
      5 => 'Menyukai hubungan dengan sesama',
      6 => 'Mempunyai determinasi yang kuat',
      7 => 'Karakternya tenang',
      8 => 'Stabil dan daya tahannya tinggi',
      9 => 'Ulet dalam memulai pekerjaan',
      10 => 'Berusaha keras mencapai sasarannya',
      11 => 'Mandiri dan cermat',
    ),
    'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Creative Designer, Office Management, Chief Engineer, Business Consultant, Chief Financial Officer, Customer Service, National Accounts Manager, Chief Accountant, Lecturer, Projects Manager, Research Planning, Human Resources, Scientific Work, Security Specialist, Solicitor, Planner, Production Administrator.',
    'description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
  ),
  21 => 
  array (
    'index' => 21,
    'code' => 'D-S-C',
    'title' => 'Director',
    'traits' => 
    array (
      0 => 'Seorang yang obyektif dan analitis',
      1 => 'Ingin terlibat dalam situasi',
      2 => 'Ingin memberikan bantuan dan dukungan',
      3 => 'Termotivasi oleh target pribadi',
      4 => 'Berorientasi terhadap pekerjaannya',
      5 => 'Menyukai hubungan dengan sesama',
      6 => 'Mempunyai determinasi yang kuat',
      7 => 'Karakternya tenang',
      8 => 'Stabil dan daya tahannya tinggi',
      9 => 'Ulet dalam memulai pekerjaan',
      10 => 'Berusaha keras mencapai sasarannya',
      11 => 'Mandiri dan cermat',
    ),
    'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Creative Designer, Office Management, Chief Engineer, Business Consultant, Chief Financial Officer, Customer Service, National Accounts Manager, Chief Accountant, Lecturer, Projects Manager, Research Planning, Human Resources, Scientific Work, Security Specialist, Solicitor, Planner, Production Administrator.',
    'description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
  ),
  22 => 
  array (
    'index' => 22,
    'code' => 'D-C-I',
    'title' => 'CHALLENGER',
    'traits' => 
    array (
      0 => 'Seorang yang tekun',
      1 => 'Sensitif terhadap permasalahan',
      2 => 'Mempunyai keputusan yang kuat',
      3 => 'Kreatif  dalam memecahkan masalah',
      4 => 'Memiliki reaksi yang cepat',
      5 => 'Mampu mencari solusi permasalahan',
      6 => 'Banyak memberikan ide-ide.',
      7 => 'Usaha yang keras pada ketepatan',
      8 => 'Cenderung perfeksionis',
    ),
    'suitable_jobs' => 'Technical/Scientific (Directing, Management, Supervision), Engineering, Finance, Production Planning, Personnel Disciplines, Self-Employment, Credit Manager, Planner, Lecturing, Work Study, Transport, Consultancy, Industrial Relations and Computers (Selling, Software, Systems Analyst) and General Manager.',
    'description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
  ),
  23 => 
  array (
    'index' => 23,
    'code' => 'D-C-S',
    'title' => 'CHALLENGER',
    'traits' => 
    array (
      0 => 'Seorang yang tekun',
      1 => 'Sensitif terhadap permasalahan',
      2 => 'Mempunyai keputusan yang kuat',
      3 => 'Kreatif  dalam memecahkan masalah',
      4 => 'Memiliki reaksi yang cepat',
      5 => 'Mampu mencari solusi permasalahan',
      6 => 'Banyak memberikan ide-ide.',
      7 => 'Usaha yang keras pada ketepatan',
      8 => 'Cenderung perfeksionis',
    ),
    'suitable_jobs' => 'Engineering, Production and Finance (Directing, Administrating, Managing and Managing Specialist Work), Scientific, Research Planning, Personnel, Trouble Shooting, Credit Control, Chief Accountant, Accountant, Chief Engineer, Work Study, Consultancy, Designer, Draughtsman, Project Work, Security Specialist, Doctor, Attorney.',
    'description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
  ),
  24 => 
  array (
    'index' => 24,
    'code' => 'I',
    'title' => 'COMMUNICATOR',
    'traits' => 
    array (
      0 => 'Antusias',
      1 => 'Percaya',
      2 => 'Optimis',
      3 => 'Persuasif',
      4 => 'Bicara aktif',
      5 => 'Impulsif',
      6 => 'Emosional',
      7 => 'Ramah',
      8 => 'Inspirasional',
    ),
    'suitable_jobs' => 'Promoting, Demonstrating, Canvassing, Marketing Services, Public Relations, Lecturing, Advertising, Publican, Publishing, Hospitality, Retail-General, Human Resources, Journalist, Singers, Technical Writing, Tour Guide, Promotional Work, Hotelier, Dancers, Host, Actors, Travel Agent, Politician, and very soft selling.',
    'description' => 'Merupakan seorang yang antusias dan optimistik, ia lebih suka mencapai sasarannya melalui orang lain. Ia suka berhubungan dengan sesamanya - ia bahkan suka mengadakan “pesta” atau kegiatan untuk berkumpul, dan ini menunjukkan kepribadiannya yang ramah. Ia tidak suka bekerja sendirian dan cenderung bersama dengan orang lain dalam menyelesaikan proyek.  Perhatian dan fokusnya tidak sebaik apa yang dia inginkan -  maka ia membutuhkan energi yang besar untuk mampu bergerak cepat dari satu hal ke hal berikutnya tanpa penundaan.  Ia sangat menonjol dalam keterampilan berkomunikasi, dan ini merupakan salah satu kekuatan yang paling sering digunakan.  Ia memiliki kemampuan untuk memotivasi dan memberi semangat dengan kata-katanya, dan ia dikenal sebagai individu yang inspirasional. Ketika ia harus memusatkan perhatiannya pada tugas, Ia akan menjadi tidak akurat dan bahkan tidak terorganisir.  Tetapi ia akan memusatkan perhatian kepada yang harus ia senangkan, karena ia enggan sekali untuk menolak.  Ia menginginkan pengakuan sosial dan takut akan penolakan.  Ia mudah menemukan teman dan berusaha menciptakan suasana yang menyenangkan.  Ia membutuhkan seorang manajer atau supervisor untuk menentukan batas waktu yang jelas dalam pekerjaannya, ia lebih suka menggunakan gaya manajemen partisipatif yang dibangun berdasarkan hubungan yang kuat.',
  ),
  25 => 
  array (
    'index' => 25,
    'code' => 'I-S',
    'title' => 'ADVISOR',
    'traits' => 
    array (
      0 => 'Hangat',
      1 => 'Simpati',
      2 => 'Tenang dalam situasi sosial',
      3 => 'Pendengar yang baik',
      4 => 'Demonstratif',
      5 => 'Tidak memaksakan idenya pada orang lain',
      6 => 'Kurang tegas dalam memberi perintah',
      7 => 'Menerima kritik',
      8 => 'Toleran dan sabar',
      9 => 'Penjaga damai',
    ),
    'suitable_jobs' => 'Personnel, Welfare, Training, Hotelier, Promoting, Travel Agent, Lecturing, Upmarket/Speciality Sales, Soft/Service Selling, Beauty Therapist, Psychologist, Nursing, Human Resources, Retail-Specialist, Veterinarian, Social Work, Personal Assistant, Personnel-HR, Coach, Mentor.',
    'description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan "penjaga damai" dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
  ),
  26 => 
  array (
    'index' => 26,
    'code' => 'I-C',
    'title' => 'ASSESSOR',
    'traits' => 
    array (
      0 => 'Ramah',
      1 => 'Suka berteman',
      2 => 'Nyaman walapun dengan orang asing',
      3 => 'Mudah mengembangkan hubungan baru',
      4 => 'Dapat mengendalikan diri',
      5 => 'Sangat sosial',
      6 => 'Cenderung perfeksionis alamiah',
      7 => 'Mempromosikan tugas-tugas orang lain',
    ),
    'suitable_jobs' => 'Teaching, Training, Inventing, Specialist Selling (Engineering, Finance or any area involving capital equipment), Project Engineer, Finance, Service Engineer or Supervising within a Technical/Specialist Area, Public Relations, Environmentalist, Marketing, Conference Organiser, Estate Agent.',
    'description' => 'Merupakan seorang yang ramah dan suka berteman; ia merasa nyaman walaupun dengan orang asing. Ia dapat mengembangkan hubungan baru dengan mudah, dan pada umumnya dapat mengendalikan diri sampai pada tingkat dimana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia seorang yang sangat sosial, menunjukkan kepedulian dan persahabatan ketika sedang melakukan tugas-tugas di tangannya. Ia cenderung perfeksionis secara alamiah, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan.  Ia berkeinginan mempromosikan tugas-tugas orang lain, juga kepunyaannya.  Kadang-kadang ia salah menilai kemampuan orang lain dikarenakan pandangan-pandangannya yang optimis.',
  ),
  27 => 
  array (
    'index' => 27,
    'code' => 'I-C-D',
    'title' => 'ASSESSOR',
    'traits' => 
    array (
      0 => 'Analitis',
      1 => 'Berwatak hati-hati',
      2 => 'Ramah pada saat merasa nyaman',
      3 => 'Sangat biasa dengan orang asing',
      4 => 'Mudah mengembangkan hubungan baru',
      5 => 'Dapat mengendalikan diri',
      6 => 'Peduli dan ramah',
      7 => 'Memusatkan perhatian pada penyelesaian tugas',
      8 => 'Perfeksionis secara alami',
      9 => 'Mengisolasi dirinya jika diperlukan',
      10 => 'Mudah diramalkan',
      11 => 'Berorientasi pada kualitas',
    ),
    'suitable_jobs' => 'Specialist/Technical Selling (Computer, Finance, Engineer and others, Technical/Capital Equipment Selling), Financial (Manager, Specialist), Engineering (Manager, Designer, Buyer, Draughtsman), Project Engineer, Sales Engineer, Consultant, Trainer, Lecturer, Hotelier, Travel Agent, Personnel and Marketing Services.',
    'description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
  ),
  28 => 
  array (
    'index' => 28,
    'code' => 'I-C-S',
    'title' => 'RESPONSIVE & THOUGHTFUL',
    'traits' => 
    array (
      0 => 'High Energy',
      1 => 'Good Communication Skill',
      2 => 'To The Point',
      3 => 'Sensitif',
      4 => 'Banyak Bicara',
      5 => 'Need Recognation',
      6 => 'Need Socialism',
      7 => 'Anti thd Kritik',
      8 => 'Terlalu banyak bersosialisasi',
      9 => 'Leadership kurang',
      10 => 'Kurang Fokus',
      11 => 'Anti Deadline',
    ),
    'suitable_jobs' => 'Personnel, Welfare, Training, Attorney, Teaching, Accounting, Technical Instructor, Customer Services, Public Relations, Artist, Hotelier, Demonstrator, Engineering (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Services), Selling, Purchasing, Supervising (Engineering, Production, Accounts), Administration Work, Secretarial, Industrial Relations Specialist.',
    'description' => 'Merupakan individu yang berorientasi pada orang dan lancar berkomunikasi serta loyal.  Ia cenderung sensitif dan mempunyai standard yang tinggi.  Keputusannya dibuat berdasarkan fakta dan data pendukung.  Ia sepertinya tidak bisa diam.  Ia perlu untuk lebih terus terang dan jangan terlalu subyektif.  Ia butuh pengakuan sosial dan perhatian pribadi; ia dapat cepat akrab dengan orang lain.  Ia bersahabat, antusias, informal, banyak bicara dan terlalu khawatir terhadap apa yang dipikirkan orang.  Ia menguasai banyak hal.  Ia ingin diterima sebagai anggota kelompok dan ingin mengetahui secara pasti apa yang diharapkan darinya sebelum ia memulai proyek baru.',
  ),
  29 => 
  array (
    'index' => 29,
    'code' => 'S-D',
    'title' => 'SELF-MOTIVATED',
    'traits' => 
    array (
      0 => 'Objektif & Analitis',
      1 => 'Mandiri',
      2 => 'Good planner',
      3 => 'Komitmen terhadap target',
      4 => 'Menghindari konflik',
      5 => 'Ingin terlibat dalam situasi',
      6 => 'Ingin memberikan bantuan dan dukungan',
      7 => 'Termotivasi oleh target pribadi',
      8 => 'Stabil',
      9 => 'Tekun',
    ),
    'suitable_jobs' => 'Investigator, Researcher, Accountant, Engineering, Production/Engineering Supervisor, Computer Specialist, Architect, Transport/Warehouse Supervisor, Credit Controller, DP Supervisor, Computer Specialist, Research and Development, Private Investigator, Quality Controller, Engineering (Designer, Draughtsman, Project Engineer), Sales and Service Engineer, Property Manager, Attorney, Administration Manager',
    'description' => 'Merupakan seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan juga ingin memberikan bantuan dan dukungan.  Secara internal termotivasi oleh target pribadi, Ia menyukai orang-orang, tetapi juga mempunyai kemampuan untuk berorientasi pada pekerjaannya pada saat dibutuhkan.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya memiliki kontribusi akan keberhasilannya.  Keuletannya setelah memulai pekerjaan, ia akan berusaha keras untuk mendapatkan sasarannya.  Seorang yang bebas, ia orang yang cermat dan memiliki tindak lanjut yang baik.  Ia bisa menjadi tidak ramah walaupun ia pada dasarnya ia yang berorientasi pada orang; dan pada situasi yang tidak membuatnya nyaman, ia lebih suka mendukung pemimpinnya dari pada keterlibatannya dengan situasi.',
  ),
  30 => 
  array (
    'index' => 30,
    'code' => 'S-I',
    'title' => 'ADVISOR',
    'traits' => 
    array (
      0 => 'Hangat',
      1 => 'Simpati dan Pengertian',
      2 => 'Tenang dalam situasi sosial',
      3 => 'Pendengar yang baik',
      4 => 'Demonstratif',
      5 => 'Tidak memaksakan idenya pada orang lain',
      6 => 'Kurang tegas dalam memberi perintah',
      7 => 'Menerima kritik',
      8 => 'Toleran dan sabar',
      9 => 'Penjaga damai',
    ),
    'suitable_jobs' => 'Personnel Welfare, Training, Hotelier, Promoting, Travel Agent, Lecturing, Child Care, Charitable Organizations, Soft or Service Selling, Psychologist, Therapist, Nurse, Personal Assistant, Hospitality Manager, Social Work, Student Services, Upmarket/Speciality Sales.',
    'description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan "penjaga damai" yang sebenarnya dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
  ),
  31 => 
  array (
    'index' => 31,
    'code' => 'S-D-I',
    'title' => 'DIRECTOR',
    'traits' => 
    array (
      0 => 'Seorang yang obyektif dan analitis',
      1 => 'Ingin terlibat dalam situasi',
      2 => 'Ingin memberikan bantuan dan dukungan',
      3 => 'Termotivasi oleh target pribadi',
      4 => 'Berorientasi terhadap pekerjaannya',
      5 => 'Menyukai hubungan dengan sesama',
      6 => 'Mempunyai determinasi yang kuat',
      7 => 'Karakternya tenang',
      8 => 'Stabil dan daya tahannya tinggi',
      9 => 'Ulet dalam memulai pekerjaan',
      10 => 'Berusaha keras mencapai sasarannya',
      11 => 'Mandiri dan cermat',
    ),
    'suitable_jobs' => 'Engineering and Production (Supervision), Service Selling, Distribution and Warehouse Supervision/Manager, Office Management, Customer Service, System Analyst, Radio Announcer, Technical Writing, Telemarketing, TV Presenter, Project Engineer, Film Producer, Programmer, Sales/Service Engineer, Accounting, Draughtsman, Project Engineer.',
    'description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
  ),
  32 => 
  array (
    'index' => 32,
    'code' => 'S-I-D',
    'title' => 'ADVISOR',
    'traits' => 
    array (
      0 => 'Hangat',
      1 => 'Simpati dan Pengertian',
      2 => 'Tenang dalam situasi sosial',
      3 => 'Pendengar yang baik',
      4 => 'Demonstratif',
      5 => 'Tidak memaksakan idenya pada orang lain',
      6 => 'Kurang tegas dalam memberi perintah',
      7 => 'Menerima kritik',
      8 => 'Toleran dan sabar',
      9 => 'Penjaga damai',
    ),
    'suitable_jobs' => 'Engineering and Production (Supervision), Service Selling, Distribution and Warehouse Supervision, Office Management, Customer Service, System Analyst, Programmer, Sales/Service Engineer, Accounting, Draughtsman, Project Engineer.',
    'description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan "penjaga damai" yang sebenarnya dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
  ),
  33 => 
  array (
    'index' => 33,
    'code' => 'S-I-C',
    'title' => 'ADVOCATE',
    'traits' => 
    array (
      0 => 'Stabil',
      1 => 'Ramah',
      2 => 'Detail ketika situasi membutuhkan',
      3 => 'Cenderung individualis',
      4 => 'Teguh pendirian',
      5 => 'Menyukai hubungan dengan orang',
      6 => 'Mendukung pihak yang lemah',
      7 => 'Ingin diterima sebagai anggota tim',
      8 => 'Ingin orang lain menyukainya',
      9 => 'Sulit membuat keputusan',
      10 => 'Moderat',
      11 => 'Cermat dan dapat diandalkan',
    ),
    'suitable_jobs' => 'Personnel Welfare, Training, Teaching, Attorney, Accounting, Technical Instructor, Customer Service, Public Relations, Artist, Hotelier, Demonstrator, Engineer (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Service), Selling, Purchasing, Supervising (Engineering, Production, Accounts) Administrative Work, Secretarial.',
    'description' => 'Merupakan orang yang stabil, individu yang ramah yang berusaha keras membangun hubungan yang positif di tempat kerja dan di rumah.  Ia dapat menjadi sangat berorientasi detil ketika situasi membutuhkan; tetapi secara keseluruhan ia cenderung individualis, independen dan sedikit perhatian terhadap detil.  Sekali dia membuat keputusan, sangat sulit mengubah pendiriannya.  Ia menyukai hubungan dengan orang dan cenderung mendukung pihak yang lemah.  Ia akan mengambil posisi berlawanan dengan ketidaksepakatan dan merasa frustrasi jika sesuatu tidak sejalan dengannya.  Ia ingin diterima sebagai anggota tim, dan ia menginginkan orang lain menyukainya.  Ia cukup sulit membuat keputusan sampai parameter wewenang secara jelas ditentukan, dan ia mungkin cenderung tidak sungguh-sungguh jika dipaksa membuat keputusan ketika ia tidak ingin melakukannya.  Ia menginginkan orang lain yang membuat keputusan, khususnya jika ada orang yang sangat ia hargai dan hormati.  Ia cenderung moderat, cermat dan dapat diandalkan.',
  ),
  34 => 
  array (
    'index' => 34,
    'code' => 'S-C-D',
    'title' => 'INQUIRER',
    'traits' => 
    array (
      0 => 'Seorang yang baik',
      1 => 'Sangat berorientasi pada detil',
      2 => 'Sangat teliti dalam penyelesaian tugas',
      3 => 'Sangat berhati-hati',
      4 => 'Penuh pertimbangan',
      5 => 'Lambat adaptasi',
      6 => 'Kaku dan keras kepala',
    ),
    'suitable_jobs' => 'Directing, Managing or Supervising (in Engineering, Accountancy, Research and Development and Computing disciplines), Accountant, Project Engineer, Draughtsman, Designer, Analyst, Chemist, Technician, Service Engineer, Manager, Security Specialist.',
    'description' => 'Seorang yang baik secara alamiah dan sangat berorientasi detil.  Ia peduli dengan orang-orang di sekitarnya dan mempunyai kualitas yang membuatnya sangat teliti dalam penyelesaian tugas.  Ia mempertimbangkan sekelilingnya dengan hati-hati sebelum membuat keputusan untuk melihat pengaruhnya pada mereka; saat tertentu ia terlalu hati-hati.  Jika ia merasa seseorang memanfaatkan situasi, ia akan memperlambat kerjanya sehingga dapat mengamati apa yang sedang berlangsung di sekitarnya.',
  ),
  35 => 
  array (
    'index' => 35,
    'code' => 'S-C-I',
    'title' => 'ADVOCATE',
    'traits' => 
    array (
      0 => 'Stabil',
      1 => 'Ramah',
      2 => 'Detail ketika situasi membutuhkan',
      3 => 'Cenderung individualis',
      4 => 'Teguh pendirian',
      5 => 'Menyukai hubungan dengan orang',
      6 => 'Mendukung pihak yang lemah',
      7 => 'Ingin diterima sebagai anggota tim',
      8 => 'Ingin orang lain menyukainya',
      9 => 'Sulit membuat keputusan',
      10 => 'Moderat',
      11 => 'Cermat dan dapat diandalkan',
    ),
    'suitable_jobs' => 'Personnel Welfare, Administrator, Advisers, Training, Teaching, Attorney, Accounting, Counseling, Technical Instructor, Customer Service, Accounting-General, Public Relations, Accounts Supervisor, Artist, Hotelier, Demonstrator, Engineer (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Service), Selling, Purchasing, Sales Engineer, Legal, Negotiator, Student Service, Photographer, Physiotherapist, Project Engineer, Vocational Education, Supervising (Engineering, Production, Accounts) Administrative Work, Demonstrator, Secretarial, Hospitality Manager.',
    'description' => 'Merupakan orang yang stabil, individu yang ramah yang berusaha keras membangun hubungan yang positif di tempat kerja dan di rumah.  Ia dapat menjadi sangat berorientasi detil ketika situasi membutuhkan; tetapi secara keseluruhan ia cenderung individualis, independen dan sedikit perhatian terhadap detil.  Sekali dia membuat keputusan, sangat sulit mengubah pendiriannya.  Ia menyukai hubungan dengan orang dan cenderung mendukung pihak yang lemah.  Ia akan mengambil posisi berlawanan dengan ketidaksepakatan dan merasa frustrasi jika sesuatu tidak sejalan dengannya.  Ia ingin diterima sebagai anggota tim, dan ia menginginkan orang lain menyukainya.  Ia cukup sulit membuat keputusan sampai parameter wewenang secara jelas ditentukan, dan ia mungkin cenderung tidak sungguh-sungguh jika dipaksa membuat keputusan ketika ia tidak ingin melakukannya.  Ia menginginkan orang lain yang membuat keputusan, khususnya jika ada orang yang sangat ia hargai dan hormati.  Ia cenderung moderat, cermat dan dapat diandalkan.',
  ),
  36 => 
  array (
    'index' => 36,
    'code' => 'C-I',
    'title' => 'ASSESSOR',
    'traits' => 
    array (
      0 => 'Analitis',
      1 => 'Berwatak hati-hati',
      2 => 'Ramah pada saat merasa nyaman',
      3 => 'Sangat biasa dengan orang asing',
      4 => 'Mudah mengembangkan hubungan baru',
      5 => 'Dapat mengendalikan diri',
      6 => 'Peduli dan ramah',
      7 => 'Memusatkan perhatian pada penyelesaian tugas',
      8 => 'Perfeksionis secara alami',
      9 => 'Mengisolasi dirinya jika diperlukan',
      10 => 'Mudah diramalkan',
      11 => 'Berorientasi pada kualitas',
    ),
    'suitable_jobs' => 'Sales (Technical/Specialist), Public Relations, Lecturer, Academic, Personnel Administration, Purchasing, Travel Agent, Training, Teaching, Real Estate Agent, Hospitality Administration, Sales-Technical, Hotelier, Project Engineer, Service Engineer.',
    'description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
  ),
  37 => 
  array (
    'index' => 37,
    'code' => 'C-D-I',
    'title' => 'CHALLENGER',
    'traits' => 
    array (
      0 => 'Sangat berorientasi pada tugas',
      1 => 'Sensitif terhadap permasalahan',
      2 => 'Lebih mempedulikan tugas daripada orang',
      3 => 'Kukuh/keras',
      4 => 'Dingin',
      5 => 'Tidak berperasaan',
      6 => 'Menjaga jarak',
      7 => 'Membuat keputusan berdasarkan fakta',
      8 => 'Pendiam',
      9 => 'Tidak mudah percaya',
    ),
    'suitable_jobs' => 'Directing, Managing or Supervising (Engineering, Research, Finance, Planning), Designer, Work Study, Sales (Technical/ Specialist), Logistic Support, Systems Analyst, Lecturer, Company Secretary, Negotiator and Purchasing.',
    'description' => 'Seorang yang sangat berorientasi pada tugas dan sensitif pada permasalahan. Ia lebih mempedulikan tugas yang ada dibanding orang-orang di sekitarnya, termasuk perasaan mereka. Ia sangat kukuh/keras dan mempunyai pendekatan yang efektif dalam pemecahan masalah. Oleh karena sifat alamiah dan keinginannya akan hasil yang terukur, ia akan tampak dingin, tidak berperasaan dan menjaga jarak. Ia membuat keputusan berdasar pada fakta, bukan emosi. ia cenderung pendiam dan tidak mudah percaya.',
  ),
  38 => 
  array (
    'index' => 38,
    'code' => 'C-D-S',
    'title' => 'CONTEMPLATOR',
    'traits' => 
    array (
      0 => 'Berorientasi pada hal-hal detil',
      1 => 'Mempunyai standar tinggi untuk dirinya',
      2 => 'Logis dan analitis',
      3 => 'Ingin berbuat yang terbaik',
      4 => 'Selalu berpikir ada ruang untuk kemajuan',
      5 => 'Kompetitif',
      6 => 'Ingin menghasilkan mutu yang terbaik',
      7 => 'Mampu mencapai sasarannya',
      8 => 'Sangat memusatkan perhatian pada tugas',
      9 => 'Mantap dan dapat diandalkan',
    ),
    'suitable_jobs' => 'Engineering, Research, Production and Finance (Director, Manager atau Supervisor), Work Study, Accountant, Administrator, Quality Controller, Safety Officer, Market Analyst, Planner and Personnel (Director, Manager, Administrator), MIS Manager, Security Manager, Loss Control.',
    'description' => 'Berorientasi pada hal detil dan mempunyai standard tinggi untuk dirinya. Ia logis dan analitis. Ia ingin berbuat yang terbaik, dan ia selalu berpikir ada ruang untuk peningkatan/kemajuan. Ia cenderung kompetitif dan ingin menghasilkan pekerjaan dengan mutu yang terbaik. Ia sebenarnya sensitif terhadap orang-orang, tetapi karena sifat logisnya, orientasinya terhadap tugas dapat menutupinya dengan mudah. Ia suka dihargai untuk pekerjaannya yang berkualitas. Ia mampu mengerjakan tugas-tugas; dan mencapai sasarannya. Ia sangat memusatkan perhatian pada tugas yang ada, mantap dan dapat diandalkan.',
  ),
  39 => 
  array (
    'index' => 39,
    'code' => 'C-I-D',
    'title' => 'ASSESSOR',
    'traits' => 
    array (
      0 => 'Analitis',
      1 => 'Berwatak hati-hati',
      2 => 'Ramah pada saat merasa nyaman',
      3 => 'Sangat biasa dengan orang asing',
      4 => 'Mudah mengembangkan hubungan baru',
      5 => 'Dapat mengendalikan diri',
      6 => 'Peduli dan ramah',
      7 => 'Memusatkan perhatian pada penyelesaian tugas',
      8 => 'Perfeksionis secara alami',
      9 => 'Mengisolasi dirinya jika diperlukan',
      10 => 'Mudah diramalkan',
      11 => 'Berorientasi pada kualitas',
    ),
    'suitable_jobs' => 'Directing, Managing or Supervising (Engineering, Research, Finance, Planning), Designer, Work Study, Sales (Technical/Specialist), Lecturer, Company Secretary, Negotiator and Purchasing.',
    'description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
  ),
  40 => 
  array (
    'index' => 40,
    'code' => 'C-S-D',
    'title' => 'PRECISIONIST',
    'traits' => 
    array (
      0 => 'Sistematis dan Prosedural',
      1 => 'Teratur & memiliki perencanaan yang baik',
      2 => 'Teliti',
      3 => 'Fokus pada detil',
      4 => 'Bijaksana',
      5 => 'Diplomatis',
      6 => 'Jarang menentang rekan kerjanya',
      7 => 'Ia sangat berhati-hati',
      8 => 'Mengharapkan akurasi dan standard tinggi',
      9 => 'Menginginkan adanya petunjuk standard',
      10 => 'Tidak menginginkan perubahan mendadak',
    ),
    'suitable_jobs' => 'Engineering, Research Director, Production and Finance (Director, Manager, Supervisor), Work Study, Accountant, Administrator, Quality Controller, Financial Services Manager, Safety Officer, Market Analyst, Planner and Personnel (Director, Manager, Administrator), MIS Manager, Electrician, Security Manager, Financial Researcher, Planner, Printer, Production Controller, Production Manager, Personnel Management, Loss Control.',
    'description' => 'Berpikir sistematis dan cenderung mengikuti prosedur dalam kehidupan pribadi dan pekerjaannya.  Teratur dan memiliki perencanaan yang baik, ia teliti dan fokus pada detil.  Ia bertindak dengan penuh kebijaksanaan, diplomatis dan jarang menentang rekan kerjanya dengan sengaja.  Ia sangat berhati-hati, ia sungguh-sungguh mengharapkan akurasi dan standard tinggi dalam pekerjaannya.  Ia cenderung terjebak dalam hal detil, khususnya jika harus memutuskan.  ia menginginkan adanya petunjuk standard pelaksanaan kerja dan tanpa perubahan mendadak.',
  ),
);

    /**
     * Get all 40 standard patterns.
     */
    public function getPatterns(): array
    {
        return $this->patterns;
    }

    /**
     * Get pattern by 1-based index (1..40).
     */
    public function getPatternByIndex(int $index): ?array
    {
        return $this->patterns[$index] ?? null;
    }

    /**
     * Match converted DISC scores (D, I, S, C) against the 40 standard patterns.
     *
     * @param array<string, float|int> $scores
     * @return array
     */
    public function evaluate(array $scores): array
    {
        $D = (float) ($scores['D'] ?? 0);
        $I = (float) ($scores['I'] ?? 0);
        $S = (float) ($scores['S'] ?? 0);
        $C = (float) ($scores['C'] ?? 0);

        for ($idx = 1; $idx <= 40; $idx++) {
            $matched = false;
            switch ($idx) {
                case 1:  $matched = ($D <= 0 && $I <= 0 && $S <= 0 && $C > 0); break;
                case 2:  $matched = ($D > 0 && $I <= 0 && $S <= 0 && $C <= 0); break;
                case 3:  $matched = ($D > 0 && $I <= 0 && $S <= 0 && $C > 0 && $C >= $D); break;
                case 4:  $matched = ($D > 0 && $I > 0 && $S <= 0 && $C <= 0 && $I >= $D); break;
                case 5:  $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0); break;
                case 6:  $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0); break;
                case 7:  $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0); break;
                case 8:  $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $S >= $D && $D >= $C); break;
                case 9:  $matched = ($D > 0 && $I > 0 && $S <= 0 && $C <= 0 && $D >= $I); break;
                case 10: $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0); break;
                case 11: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C <= 0 && $D >= $S); break;
                case 12: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0); break;
                case 13: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0); break;
                case 14: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0 && $I >= $S && $I >= $C); break;
                case 15: $matched = ($D <= 0 && $I <= 0 && $S > 0 && $C <= 0); break;
                case 16: $matched = ($D <= 0 && $I <= 0 && $S > 0 && $C > 0 && $C >= $S); break;
                case 17: $matched = ($D <= 0 && $I <= 0 && $S > 0 && $C > 0 && $S >= $C); break;
                case 18: $matched = ($D > 0 && $I <= 0 && $S <= 0 && $C > 0 && $D >= $C); break;
                case 19: $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0); break;
                case 20: $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0); break;
                case 21: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $D >= $S && $S >= $C); break;
                case 22: $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0 && $D >= $C && $C >= $I); break;
                case 23: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $D >= $C && $C >= $S); break;
                case 24: $matched = ($D <= 0 && $I > 0 && $S <= 0 && $C <= 0); break;
                case 25: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C <= 0 && $I >= $S); break;
                case 26: $matched = ($D <= 0 && $I > 0 && $S <= 0 && $C > 0 && $I >= $C); break;
                case 27: $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0 && $I >= $C && $C >= $D); break;
                case 28: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0 && $I >= $C && $C >= $S); break;
                case 29: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C <= 0 && $S >= $D); break;
                case 30: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C <= 0 && $S >= $I); break;
                case 31: $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0 && $S >= $D && $D >= $I); break;
                case 32: $matched = ($D > 0 && $I > 0 && $S > 0 && $C <= 0 && $S >= $I && $I >= $D); break;
                case 33: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0 && $S >= $I && $I >= $C); break;
                case 34: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $S >= $C && $C >= $D); break;
                case 35: $matched = ($D <= 0 && $I > 0 && $S > 0 && $C > 0 && $S >= $C && $C >= $I); break;
                case 36: $matched = ($D <= 0 && $I > 0 && $S <= 0 && $C > 0 && $C >= $I); break;
                case 37: $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0 && $C >= $D && $D >= $I); break;
                case 38: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $C >= $D && $D >= $S); break;
                case 39: $matched = ($D > 0 && $I > 0 && $S <= 0 && $C > 0 && $C >= $I && $I >= $D); break;
                case 40: $matched = ($D > 0 && $I <= 0 && $S > 0 && $C > 0 && $C >= $S && $S >= $D); break;
            }

            if ($matched && isset($this->patterns[$idx])) {
                return $this->patterns[$idx];
            }
        }

        // Intelligent Fallback if borderline/all negative/tied: Pick top dimension pattern
        arsort($scores);
        $topDim = array_key_first($scores);
        return match ($topDim) {
            'D' => $this->patterns[2] ?? reset($this->patterns),
            'I' => $this->patterns[24] ?? reset($this->patterns),
            'S' => $this->patterns[15] ?? reset($this->patterns),
            'C' => $this->patterns[1] ?? reset($this->patterns),
            default => $this->patterns[1] ?? reset($this->patterns),
        };
    }

    /**
     * Evaluate all 3 lines (Most, Least, Change).
     *
     * @param array $line1Conv
     * @param array $line2Conv
     * @param array $line3Conv
     * @return array
     */
    public function evaluateAll(array $line1Conv, array $line2Conv, array $line3Conv): array
    {
        return [
            'most' => $this->evaluate($line1Conv),
            'least' => $this->evaluate($line2Conv),
            'change' => $this->evaluate($line3Conv),
        ];
    }
}
