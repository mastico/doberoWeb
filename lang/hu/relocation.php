<?php

return [

    'title'       => 'Költözés',
    'subtitle'    => 'DOBERO',
    'description' => 'Lépésről lépésre útmutató a spanyolországi, Costa Blanca-i letelepedéshez.',
    'nav_label'   => 'Gyors Navigáció',

    'nav' => [
        'notary'            => 'Meghatalmazás',
        'nie'               => 'NIE szám',
        'bank'              => 'Bankszámla nyitás',
        'address'           => 'Empadronamiento (Lakcímbejelentés)',
        'residency'         => 'Európai tartózkodási engedély',
        'digital-signature' => 'Digitális aláírás',
        'transcript'        => 'Közüzemi átírás',
    ],

    'notary' => [
        'title'     => 'Meghatalmazás',
        'intro'     => 'A lakásvásárló és képviselője közötti meghatalmazás jogi felhatalmazást ad a képviselőnek, hogy az ingatlan adásvételével kapcsolatos minden ügyben a vevő nevében járjon el. A vevő a képviselőre ruházza hatáskörét, hogy bizonyos intézkedéseket helyette elvégezhessen.',
        'h_uses'    => 'Mire használják lakásvásárláskor?',
        'uses'      => [
            '<strong>Ha a vevő külföldön él:</strong> A meghatalmazás lehetővé teszi, hogy egy spanyolországi képviselő intézze az összes ügymenetet, anélkül hogy a vevőnek folyamatosan utaznia kellene.',
            '<strong>Ha a vevő nem tud jelen lenni:</strong> Munkája, betegsége vagy egyéb körülmények miatt a meghatalmazás lehetővé teszi, hogy képviselője helyette járjon el.',
            '<strong>A folyamat felgyorsítása érdekében:</strong> A meghatalmazással rendelkező képviselő döntéseket hozhat és intézkedhet állandó jóváhagyás nélkül.',
            '<strong>A biztonság növelése érdekében:</strong> A vevő esetleg ügyvédet vagy ingatlankezelőt preferál az adásvétel lebonyolítására, hogy minden a törvénynek megfelelően történjen.',
        ],
        'h_actions' => 'A képviselő által elvégezhető cselekmények',
        'actions'   => [
            'Szerződések aláírása a vevő nevében',
            'Jelzáloghitel vagy egyéb finanszírozás intézése',
            'A szükséges kifizetések teljesítése a vevő nevében',
            'Az adásvételhez szükséges dokumentáció kezelése',
            'Megjelenés az eladóval, közjegyzővel stb. folytatott találkozókon',
        ],
        'note' => 'A meghatalmazást közjegyző előtt kell megadni, és egyértelműen meg kell határoznia a képviselő jogkörét. A rosszul megfogalmazott meghatalmazás jogi problémákhoz vezethet. Forduljon ügyvédhez, hogy az megfeleljen a vevő összes igényének.',
    ],

    'nie' => [
        'title' => 'NIE szám',
        'badge' => '24–48h',
        'intro' => 'A <strong>Külföldi Azonosítószám (NIE)</strong> egy adóazonosító kód, amelyet azoknak a külföldi állampolgároknak adnak ki, akik Spanyolországban élnek, vagy jogi, adminisztratív ügyeket intéznek ott. A spanyol adóazonosítónak (NIF) megfelelője, de külföldiek számára.',
        'h_uses' => 'Mire jó a NIE?',
        'uses'   => [
            'Ingatlan vétele vagy eladása — elengedhetetlen minden ingatlanügyletnél',
            'Bankszámla nyitása — a legtöbb bank megköveteli',
            'Munkavállalás Spanyolországban — szükséges munkaszerződésekhez és a Társadalombiztosításhoz',
            'Autóvezetés Spanyolországban — jogosítvány igényléséhez vagy megújításához',
            'Egészségügyi kártya igénylése — a közegészségügyi rendszer eléréséhez',
            'Főiskolai vagy iskolai beiratkozás',
            'Cégalapítás vagy vállalkozás bejegyzése',
            'Adóbevallás benyújtása',
            'Vízum vagy tartózkodási engedély igénylése',
        ],
        'note' => 'A NIE elengedhetetlen dokumentum minden külföldinek, aki élni, dolgozni vagy jogi ügyeket intézni szeretne Spanyolországban. A DOBERO 24–48 órán belül intézi az Ön NIE-jét.',
    ],

    'bank' => [
        'title'       => 'Bankszámla nyitás',
        'intro'       => 'A spanyolországi bankszámla elengedhetetlen a tartózkodási engedéllyel rendelkező külföldiek számára a mindennapi életbe való teljes beilleszkedéshez. Széles körű pénzügyi tranzakciók és ügyintézések elvégzését teszi lehetővé.',
        'h_uses'      => 'Mit tehet egy spanyol bankszámlával?',
        'uses'        => [
            'Fizetésének közvetlen átutaltatása a számlájára',
            'Adók befizetése — mind országos, mind regionális szinten',
            'Közüzemi számlák fizetése (villany, víz, gáz, internet, bérleti díj)',
            'Biztonságos online vásárlás',
            'Nemzetközi utalások fogadása családtagoktól vagy barátoktól',
            'Megtakarítások és befektetések kezelése Spanyolországban',
            'Járandó szociális juttatások fogadása',
            'Bankkártya és hitelkártya használata ATM-eknél és üzletekben',
            'Fizetés Bizummal — Spanyolország gyors személyek közötti fizetési alkalmazásával',
        ],
        'h_important' => 'Fontos tudnivalók',
        'important'   => [
            '<strong>Szükséges dokumentumok:</strong> NIE, útlevél vagy személyi igazolvány, és esetleg lakcímigazolás',
            '<strong>Tartózkodási követelmények:</strong> Egyes bankok minimális tartózkodási időt kérhetnek',
            '<strong>Díjak:</strong> Hasonlítsa össze a számlavezetési díjakat, átutalási költségeket és kártyaköltségeket a bankok között',
            '<strong>Adók:</strong> A megtakarítások kamatai spanyol adókötelezettség alá eshetnek',
            '<strong>Nyelv:</strong> Sok bank kínál angol nyelvű szolgáltatást; az alapszintű spanyol tudás hasznos',
        ],
    ],

    'address' => [
        'title'      => 'Empadronamiento (Lakcímbejelentés)',
        'intro'      => 'Az <strong>empadronamiento</strong> egy spanyol önkormányzatban lakók adminisztratív nyilvántartása — a hivatalos nyilvántartás, amely igazolja, hogy egy személy egy adott helyen él. Ez önkormányzati (nem állami) nyilvántartás.',
        'h_required' => 'Mire szükséges?',
        'required'   => [
            'Egészségügyi kártya igénylése — a közegészségügy eléréséhez',
            'Gyermekek iskolai beiratkozása',
            'Szociális segély és önkormányzati támogatás igénylése',
            'Jogosítvány igénylése vagy megújítása (bizonyos esetekben)',
            'Spanyolországi tartózkodás intézése',
            'Szavazás az önkormányzati választásokon',
            'Különféle egyéb önkormányzati adminisztratív ügyintézések',
        ],
        'h_how' => 'A regisztráció menete',
        'how'   => [
            'Menjen a lakhelye szerinti <strong>városháza (ayuntamiento)</strong> épületébe',
            'Töltse ki a regisztrációs kérelmet',
            'Mutassa be DNI/NIE-jét és útlevelét, valamint lakcímigazolást (bérleti szerződés vagy közüzemi számla)',
            'Vegye át a lakcímigazolást (ez sokszor online is igényelhető)',
        ],
        'note' => 'A lakcímigazolásnak nincs meghatározott lejárati dátuma, de egyes szervek friss igazolást (3 hónaposnál nem régebbit) kérnek. Mindig frissítse bejelentkezését, ha megváltoztatja lakcímét.',
    ],

    'residency' => [
        'title'       => 'Európai tartózkodási engedély',
        'intro'       => 'Az <strong>európai tartózkodási igazolást</strong> azoknak az EU-, EGT- vagy svájci állampolgároknak adják ki, akik több mint három hónapig tartózkodnak Spanyolországban. Nem különleges vízum, hanem a jogszerű tartózkodást igazoló hivatalos dokumentum.',
        'h_enables'   => 'Mire jogosít az EU-s tartózkodási kártya?',
        'enables'     => [
            'Hozzáférés a spanyol munkaerőpiachoz',
            'Hozzáférés az állami egészségügyhöz és oktatáshoz',
            'Bankszámla nyitása',
            'Egyéb engedélyek és licencek igénylése',
            'Lakcím igazolása adminisztratív ügyekhez',
        ],
        'h_mandatory' => 'Kötelező-e?',
        'mandatory'   => 'Ha három hónapnál tovább tartózkodik Spanyolországban, tartózkodóként kell regisztrálnia. A fizikai kártya szigorúan nem kötelező, de ez a legegyszerűbb és legpraktikusabb módja a jogszerű tartózkodás igazolásának.',
        'h_docs'      => 'Szükséges dokumentumok',
        'docs'        => [
            'Érvényes útlevél vagy személyi igazolvány',
            'Kitöltött kérelemnyomtatvány',
            'Spanyolországi lakcímigazolás (pl. bérleti szerződés)',
            'Friss fénykép',
            'Az illetékes díj befizetése',
        ],
        'note' => 'A kérelmet a tartózkodási helye szerinti tartomány Bevándorlási Hivatalánál kell benyújtani. A díjak általában alacsonyak — érdeklődjön helyben az aktuális költségekről és eljárásokról.',
    ],

    'digital_signature' => [
        'title'     => 'Digitális aláírás',
        'intro'     => 'A <strong>digitális aláírás</strong> garantálja az elektronikus dokumentum hitelességét, integritását és letagadhatatlanságát. Megerősíti, hogy a dokumentumot nem módosították, és azt az azonosított személy írta alá. A beszkennelt kézzel írott aláírástól eltérően jóval magasabb biztonságot és teljes körű jogi érvényességet biztosít.',
        'h_uses'    => 'Leggyakoribb felhasználási területek',
        'uses'      => [
            'Online szerződések aláírása',
            'Adóbevallások benyújtása a spanyol Adóhivatalnál (Agencia Tributaria)',
            'Hivatalos adminisztratív dokumentumok aláírása',
            'Pénzügyi tranzakciók jóváhagyása',
            'Elektronikus kommunikáció védelme',
            'Biztonságos kormányzati rendszerekhez való hozzáférés',
        ],
        'h_stored'  => 'Hol tárolják?',
        'stored'    => [
            '<strong>Hardveres token (USB vagy intelligens kártya)</strong> — a legbiztonságosabb megoldás',
            '<strong>Tanúsítványszoftver a számítógépen</strong> — kényelmes, de kevésbé biztonságos',
        ],
        'h_managed' => 'Ki kezeli?',
        'managed'   => 'A felhasználó felelős a privát kulcsa védelméért. A Hitelesítő Hatóság (CA) kiállítja és kezeli a tanúsítványt, de nem tárolja a privát kulcsot.',
        'note' => 'A digitális aláírások biztonságos és jogilag érvényes elektronikus tranzakciókat tesznek lehetővé Spanyolországban. Kezelje felelősséggel a tanúsítványát — a privát kulcs elvesztése esetén újra kell igényelni a tanúsítványt.',
    ],

    'transcript' => [
        'title' => 'Közüzemi átírás',
        'intro' => 'A <strong>közüzemi átírás</strong> az ingatlan megvásárlása után az áram-, víz- és gázszerződések új tulajdonosra való átírását jelenti.',
        'h_why' => 'Miért fontos?',
        'why'   => [
            'A számlák az új tulajdonos nevére szólnak',
            'A fizetési jogi felelősség megfelelően átszáll az új tulajdonosra',
            'A szolgáltatások a vásárlás után megszakítás nélkül folytatódnak',
        ],
        'h_docs' => 'Mit kell benyújtani?',
        'docs'   => [
            'Személyi igazolvány vagy NIE szám',
            'Ingatlan adatai (cím, kataszteri hivatkozás)',
            'Bankszámlaszám (IBAN) a csoportos terheléshez',
            'Az adásvételi szerződés (<em>escritura</em>) másolata',
        ],
        'note' => 'Ez egyszerű, de fontos lépés közvetlenül az ingatlanvásárlás befejezése után. A DOBERO az értékesítés utáni támogatási szolgáltatásunk keretében intézi a közüzemi átírást.',
    ],
];
