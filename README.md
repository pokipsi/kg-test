# kg-test
kg studio test

1) edit .env
2) php artisan migrate:refresh --seed
3) php artisan passport:install
4) update .env passport data

Zadatak:

Napraviti landing page sa mogucnoscu unosa email adrese.
Nakon unosa email adrese I klika na dugme subscribe treba da se izvrsi placanje preko PayPal -a.
Nakon uspjesnoga placanja email treba da se unese u bazu pretplatnika.
Nakon uspjesnoga placanja korisniku se salje email da je uspjesno unesen u bazu pretplatnika.
U mejlu dobrodoslice treba da postoji unsubscribe dugme koje ce da pretplatnika obrise iz baze, brisanje je soft delete I korisnik treba da bude u mogucnosti kasnije ponovo da unese isti mail, ukoliko taj email vec postoji u bazi pitati ga da li zeli da ponovo aktivira account, ukoliko odgovori potvrdno poslati mu email “reaktivacije” koji ce da sadrzi link za aktiviranje. Tek nakon klika korisnik ponovo pocinje da prima emailove.

Administrator treba da ima mogucnost pregleda svih pretplatnika, sa tim da oni koji su unjeli email a nisu izvrsili placanje treba da budu oznaceni drugacije od korisnika koji su izvrili placanje.
Takodje potrebno je da postoji filter za “tip” pretplatnika, kao I paginacija, filteri I paginacija treba da budu server-side.
Administrator ima mogucnost aktivacije I deaktivacije korisnika. Bilo da se radi o aktivaciji ili deaktivaciji korisnik treba da primi email o tome.

Administrator ima CRUD funkcionalnost za citate.
Svim pretplatnicima treba jednom dnevno u odredjeno vrijeme da se salje email sa jednim od citata.
Korisnik ne smije da primi isti citat vise od jednom, takodje citati ne treba da idu random nego da se salju onim redoslijedom kojim ih je administrator unosio. 
Svaki novi pretplatnik dobija citate od pocetka liste citata.

Svi majlovi moraju da se salju preko queue -a.

Sav front-end (landing page I admin panel) treba da budu uradjeni u Vue.js.
Svi zahtjevi treba da se salju preko AJAX -a.
Obratiti paznju na maximalnu sigurnost I optimizaciju aplikacije.
Za placanje koristiti PayPal test account.

Kod je potrebno od pocetka staviti na GitHub, sav kod raditi na odvojenom branchu I mergovati ga u master preko pull request -a.

Potrebno je napraviti demo seedere za 20 citata (text moze da bude lorem ipsum), I sa 4 korisnika, jedan admin, jedan regularni korisnik koji je izvrsio placanje, jedan koji je samo unjeo email ali nije izvrsio placanje, jedan koji je obrisan (deaktiviran) I jedan koji je zatrazio reaktivaciju profila.
