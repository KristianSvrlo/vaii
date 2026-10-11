# CarMeet

Kristián Švrlo

5ZYI35

## Stručný opis projektu
Je to webová aplikácia pre autičkárov. Rieši problém, že informácie o stretnutiach/jazdách/výstavach/... sú dnes organizované po rôznych sociálnych sieťach a skupinách. Často je ťažké nájsť informácie o nich, sledovať ich progres, a zmeny v organizácií. Aplikácia umožňuje vytvárať poduajtia a jednoduché získavanie informácií o nich.

Aplikácia je určená pre hocikoho, kto sa chce zúčastniť nejakého automobilného podujatia. Každý používateľ má verejnu garáž, v ktorej prezentuje svoje autá s fotografiami a inými údahm. 

## Role v projekte
Návštevník = môže prezerať zoznam podujatí, detaily, verejné garáže a autá. Môže sa zaregistrovať a prihlásiť na stránku, ale bez prihlásenia nemôže upravovať/tvoriť žiaden obsah.

Registrovaný používateľ = spravuje svoju garáž, môže vytvárať len privátne podujatia (môže na ne pridať ostatných používateľov ale public pre každého budú len ak to admin odsúhlasí). Prihlasuje sa na podujatia iných používateĺov.

Administrátor = zodpovedá za moderovanie obsahu a správu používateľov. Môže upravit hociaké podujatie, auto alebo komentár. Môže tiež zmeniť rolu, odsúhlasiť verejné podujatie nejakého používateľa.

## Prípady použitia podľa rolí
### Návštevník
 - zaregistruje sa a prihlási do aplikácie,
 - prezerá zoznam nadchádzajúcich podujatí a filtruje ich podľa typu, mesta a dátumu,
 - otvorí detail podujatia a pozre si ho
 - prezerá verejnú garáž ľubovoľného používateľa,
 - otvorí detail auta, pozrie si jeho fotogalériu a komentár

### Registrovaný používateľ 
 - upraví svoj profil a zmení heslo,
 - pridá nové auto do svojej garáže, upraví jeho údaje alebo ho zmaže,
 - nahrá k autu fotografie, určí hlavnú fotografiu a nepotrebné fotografie zmaže,
 - vytvorí privátne podujatie (vrátane nahratia plagátu), upraví ho alebo zruší,
 - požiada administrátora o zverejnenie svojho privátneho podujatia,
 - prihlási sa na podujatie
 - odhlási sa z podujatia,
 - napíše komentár k autu a zmaže vlastný komentár,
 - zobrazí si zoznam podujatí, na ktoré sa prihlásil, a podujatí, ktoré organizuje.


### Administrátor
 - zobrazí zoznam všetkých používateľov, zmení ich rolu alebo zmaže účet,
 - zmaže nevhodný komentár, fotografiu, auto alebo podujatie,
 - zobrazí zoznam podujatí čakajúcich na schválenie a každé schváli alebo zamietne,

## Plánované entity
### Používateľ (users)
Účet používateľa slúžiaci na prihlásenie a určenie role.
Atribúty: id, username (unikátne), email (unikátny), password_hash, role (user / admin), created_at
Vzťahy: vlastní autá, organizuje podujatia, píše komentáre, prihlasuje sa na podujatia

### Auto (cars)
Auto v garáži používateľa. Je hlavným prezentačným prvkom aplikácie.
Atribúty: id, user_id (FK), brand, model, year, engine, power_kw, description, created_at
Vzťahy: patrí jednému používateľovi, má viacero fotografií a komentárov

### Fotografia auta (car_photos)
Fotogaléria jedného auta.
Atribúty: id, car_id (FK), file_path, is_main, uploaded_at
Vzťahy: patrí jednému autu

### Podujatie (events)
Automobilové podujatie. Miesto konania je uložené priamo v podujatí.
Atribúty: id, organizer_id (FK na users), title, status (private / pending / public / rejected), description, event_type (meetup / cruise / track_day / car_show / cars_and_coffee), starts_at, address, city,  created_at
Vzťahy: má jedného organizátora a viacero účastníkov

### Komentár (comments)
Komentár používateľa pod autom.
Atribúty: id, car_id (FK), user_id (FK), content, created_at
Vzťahy: patrí jednému autu a jednému autorovi

### Účasť (attendance), asociačná tabuľka
Prihlásenie používateľa na podujatie s voliteľným autom.
Atribúty: id, user_id (FK), event_id (FK), car_id (FK, nepovinné), created_at
Obmedzenia: dvojica (user_id, event_id) je unikátna, takže sa používateľ môže na podujatie prihlásiť iba raz. Server overuje, že vybrané auto patrí prihlasujúcemu sa používateľovi.

## Vzťahy medzi entitami
User – Car (1:N): používateľ môže mať viacero áut, každé auto patrí práve jednému používateľovi.
Car – CarPhoto (1:N): auto má viacero fotografií, každá fotografia patrí jednému autu.
Car – Comment (1:N): pod autom môže byť viacero komentárov, každý komentár patrí jednému autu.
User – Comment (1:N): používateľ môže napísať viacero komentárov, každý komentár má jedného autora.
User – Event (1:N): používateľ môže organizovať viacero podujatí, každé podujatie má jedného organizátora.
User – Event (M:N cez Attendance): používateľ sa môže prihlásiť na viacero podujatí a na podujatie sa môže prihlásiť viacero používateľov.


## Hlavné stránky aplikácie
Zoznam podujatí (domovská stránka): prehľad nadchádzajúcich podujatí s filtrovaním podľa typu, mesta a dátumu.
Detail podujatia: popis, plagát, miesto konania, organizátor a zoznam účastníkov s autami, tlačidlo na prihlásenie alebo odhlásenie.
Formulár podujatia: vytvorenie a úprava podujatia vrátane nahratia plagátu a validácie vstupov.
Registrácia a prihlásenie: vytvorenie účtu a prihlásenie do aplikácie.
Garáž používateľa: verejná stránka so zoznamom áut daného používateľa. Vlastník tu vidí aj tlačidlá na úpravu a mazanie.
Detail auta: technické údaje, fotogaléria a komentáre, pridávanie a mazanie komentárov bez obnovenia stránky (AJAX).
Formulár auta: pridanie a úprava auta a správa jeho fotografií (nahrávanie, mazanie, výber hlavnej fotografie).
Môj profil: úprava profilu, zoznam podujatí, na ktoré som prihlásený, a podujatí, ktoré organizujem.
Administrácia: správa používateľov a moderovanie podujatí, áut a komentárov.

## Rozdelenie funkcionality
### Základné funkcie
 - registrácia, prihlásenie a odhlásenie,
 - tri úrovne prístupu (návštevník, používateľ, administrátor) a autorizácia akcií,
 - nahrávanie fotografií áut a plagátov podujatí a správa nahraných súborov,
 - prihlasovanie na podujatia s voliteľným výberom auta,
 - komentovanie áut,
 - filtrovanie podujatí, prihlásenie a odhlásenie z podujatia, pridávanie a mazanie komentárov,
 - administrátorské moderovanie obsahu a správa používateľov,

### Rozširujúce funkcie
 - Kluby a crew: používatelia vytvárajú kluby, vstupujú do nich a kluby organizujú podujatia (nová entita s M:N vzťahom).
 - Mapa podujatia pomocou externého API (napr. OpenStreetMap / Leaflet).
 - Podujatia v mojom okolí
 - Fotogaléria podujatia, do ktorej účastníci nahrávajú fotografie po skončení akcie.
 - Páči sa mi to pri autách a rebríček najobľúbenejších áut.
 - Kapacita podujatia a zoznam náhradníkov.
 - Podoba sociálnej siete ako twitter
 - Rozšírenie komentárov aj na podujatia atď.


