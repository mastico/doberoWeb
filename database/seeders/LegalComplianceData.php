<?php

namespace Database\Seeders;

final class LegalComplianceData
{
    public static function pages(): array
    {
        return [
            [
                'key' => 'legal-notice',
                'slug' => ['en' => 'legal-notice', 'es' => 'aviso-legal', 'hu' => 'jogi-nyilatkozat'],
                'title' => ['en' => 'Legal Notice', 'es' => 'Aviso Legal', 'hu' => 'Jogi nyilatkozat'],
                'body' => [
                    'en' => '<h2>Service provider</h2><p>This website is operated by János Németh – Sole trader, NIF Y1962730Q, trading as DOBERO, for real estate brokerage and real estate services.</p><h2>Professional address and contact</h2><p>Professional address: urb.Residencial la Torre 28.</p><p>The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.</p><p>Phone: +34 674 920 844<br>Email: info@dobero.es</p><h2>Scope of information</h2><p>This website provides general information about DOBERO services. Final legal wording for liability, scope, and use conditions must be replaced with the lawyer-approved version before launch.</p><p>Last updated: September 2026.</p>',
                    'es' => '<h2>Prestador del servicio</h2><p>Este sitio web es operado por János Németh – Autónomo, NIF Y1962730Q, nombre comercial DOBERO, para actividades de intermediación inmobiliaria y servicios inmobiliarios.</p><h2>Dirección profesional y contacto</h2><p>Dirección profesional: urb.Residencial la Torre 28.</p><p>La dirección profesional indicada es provisional y está pendiente de confirmación. Sustitúyala por la dirección oficial y por un texto aprobado por asesoría jurídica antes del lanzamiento.</p><p>Teléfono: +34 674 920 844<br>Correo electrónico: info@dobero.es</p><h2>Alcance de la información</h2><p>Este sitio web ofrece información general sobre los servicios de DOBERO. La redacción jurídica definitiva sobre responsabilidad, alcance y condiciones de uso deberá sustituirse por la versión aprobada por asesoría jurídica antes del lanzamiento.</p><p>Última actualización: septiembre de 2026.</p>',
                    'hu' => '<h2>Szolgáltató</h2><p>Ezt a weboldalt János Németh – Egyéni vállalkozó üzemelteti, NIF Y1962730Q, DOBERO kereskedelmi név alatt, ingatlanközvetítési és ingatlanszolgáltatási tevékenység céljából.</p><h2>Szakmai cím és elérhetőség</h2><p>Szakmai cím: urb.Residencial la Torre 28.</p><p>A megjelenített szakmai cím megerősítésig ideiglenes. Indulás előtt cserélje le a hivatalos címre és az ügyvéd által jóváhagyott szövegre.</p><p>Telefon: +34 674 920 844<br>E-mail: info@dobero.es</p><h2>Az információk hatálya</h2><p>Ez a weboldal általános tájékoztatást ad a DOBERO szolgáltatásairól. A felelősségre, a hatályra és a használati feltételekre vonatkozó végleges jogi szöveget indulás előtt ügyvéd által jóváhagyott verzióra kell cserélni.</p><p>Utolsó frissítés: 2026. szeptember.</p>',
                ],
                'meta_title' => ['en' => 'Legal Notice', 'es' => 'Aviso Legal', 'hu' => 'Jogi nyilatkozat'],
                'meta_description' => ['en' => 'Legal identity and service provider information for DOBERO.', 'es' => 'Información legal e identificativa de DOBERO.', 'hu' => 'A DOBERO jogi és azonosító adatai.'],
                'sort_order' => 6,
                'deletable' => false,
            ],
            [
                'key' => 'privacy-policy',
                'slug' => ['en' => 'privacy-policy', 'es' => 'politica-privacidad', 'hu' => 'adatvedelmi-tajekoztato'],
                'title' => ['en' => 'Privacy Policy', 'es' => 'Política de Privacidad', 'hu' => 'Adatvédelmi tájékoztató'],
                'body' => [
                    'en' => '<h2>Controller</h2><p>The controller for this website is János Németh, NIF Y1962730Q, trading as DOBERO, for real estate brokerage and real estate services.</p><p>Contact: +34 674 920 844 · info@dobero.es</p><p>Professional address: urb.Residencial la Torre 28.</p><p>The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.</p><h2>Pending lawyer-approved copy</h2><p>Details about specific purposes, legal bases, retention periods, recipients, international transfers, and rights procedures must be added only from the approved final legal copy before launch.</p><p>Last updated: September 2026.</p>',
                    'es' => '<h2>Responsable del tratamiento</h2><p>El responsable del tratamiento vinculado a este sitio web es János Németh, NIF Y1962730Q, nombre comercial DOBERO, para actividades de intermediación inmobiliaria y servicios inmobiliarios.</p><p>Contacto: +34 674 920 844 · info@dobero.es</p><p>Dirección profesional: urb.Residencial la Torre 28.</p><p>La dirección profesional indicada es provisional y está pendiente de confirmación. Sustitúyala por la dirección oficial y por un texto aprobado por asesoría jurídica antes del lanzamiento.</p><h2>Contenido pendiente de validación jurídica</h2><p>Los detalles sobre finalidades específicas, bases jurídicas, plazos de conservación, destinatarios, transferencias internacionales y procedimientos para el ejercicio de derechos solo deben incorporarse a partir del texto legal definitivo aprobado antes del lanzamiento.</p><p>Última actualización: septiembre de 2026.</p>',
                    'hu' => '<h2>Adatkezelő</h2><p>A weboldalhoz kapcsolódó adatkezelő János Németh, NIF Y1962730Q, DOBERO kereskedelmi név alatt, ingatlanközvetítési és ingatlanszolgáltatási tevékenység céljából.</p><p>Kapcsolat: +34 674 920 844 · info@dobero.es</p><p>Szakmai cím: urb.Residencial la Torre 28.</p><p>A megjelenített szakmai cím megerősítésig ideiglenes. Indulás előtt cserélje le a hivatalos címre és az ügyvéd által jóváhagyott szövegre.</p><h2>Jóváhagyásra váró jogi szöveg</h2><p>A konkrét célokra, jogalapokra, megőrzési időkre, címzettekre, nemzetközi adattovábbításokra és jogérvényesítési eljárásokra vonatkozó részletek csak a végleges, jóváhagyott jogi szövegből kerülhetnek be indulás előtt.</p><p>Utolsó frissítés: 2026. szeptember.</p>',
                ],
                'meta_title' => ['en' => 'Privacy Policy', 'es' => 'Política de Privacidad', 'hu' => 'Adatvédelmi tájékoztató'],
                'meta_description' => ['en' => 'Privacy information placeholder for DOBERO legal compliance work.', 'es' => 'Contenido base de privacidad para el trabajo de cumplimiento legal de DOBERO.', 'hu' => 'Adatvédelmi alap tartalom a DOBERO jogi megfelelési munkájához.'],
                'sort_order' => 7,
                'deletable' => false,
            ],
            [
                'key' => 'cookie-policy',
                'slug' => ['en' => 'cookie-policy', 'es' => 'politica-cookies', 'hu' => 'suti-szabalyzat'],
                'title' => ['en' => 'Cookie Policy', 'es' => 'Política de Cookies', 'hu' => 'Cookie-szabályzat'],
                'body' => [
                    'en' => '<h2>Cookie information</h2><p>This website will publish a complete cookie policy describing necessary cookies and any optional categories enabled in production.</p><p>Owner: János Németh · DOBERO · NIF Y1962730Q</p><p>Contact: +34 674 920 844 · info@dobero.es</p><p>Professional address: urb.Residencial la Torre 28.</p><p>The professional address shown is provisional pending confirmation. Replace it with the official address and lawyer-approved wording before launch.</p><h2>Pending lawyer-approved copy</h2><p>Cookie providers, analytics or marketing purposes, retention periods, and consent mechanisms must be added only from the approved final legal copy before launch.</p><p>Last updated: September 2026.</p>',
                    'es' => '<h2>Información sobre cookies</h2><p>Este sitio web publicará una política de cookies completa para describir las cookies necesarias y cualquier categoría opcional que se active en producción.</p><p>Titular: János Németh · DOBERO · NIF Y1962730Q</p><p>Contacto: +34 674 920 844 · info@dobero.es</p><p>Dirección profesional: urb.Residencial la Torre 28.</p><p>La dirección profesional indicada es provisional y está pendiente de confirmación. Sustitúyala por la dirección oficial y por un texto aprobado por asesoría jurídica antes del lanzamiento.</p><h2>Contenido pendiente de aprobación jurídica</h2><p>Los proveedores de cookies, las finalidades analíticas o de marketing, los plazos de conservación y los mecanismos de consentimiento solo deben incorporarse a partir del texto legal definitivo aprobado antes del lanzamiento.</p><p>Última actualización: septiembre de 2026.</p>',
                    'hu' => '<h2>Cookie-tájékoztató</h2><p>Ez a weboldal teljes cookie-szabályzatot fog közzétenni, amely ismerteti a szükséges cookie-kat és a gyártásban engedélyezett opcionális kategóriákat.</p><p>Tulajdonos: János Németh · DOBERO · NIF Y1962730Q</p><p>Kapcsolat: +34 674 920 844 · info@dobero.es</p><p>Szakmai cím: urb.Residencial la Torre 28.</p><p>A megjelenített szakmai cím megerősítésig ideiglenes. Indulás előtt cserélje le a hivatalos címre és az ügyvéd által jóváhagyott szövegre.</p><h2>Jóváhagyásra váró jogi szöveg</h2><p>A cookie-szolgáltatókra, az analitikai vagy marketing célokra, a megőrzési időkre és a hozzájárulási mechanizmusokra vonatkozó részletek csak a végleges, jóváhagyott jogi szövegből kerülhetnek be indulás előtt.</p><p>Utolsó frissítés: 2026. szeptember.</p>',
                ],
                'meta_title' => ['en' => 'Cookie Policy', 'es' => 'Política de Cookies', 'hu' => 'Cookie-szabályzat'],
                'meta_description' => ['en' => 'Cookie policy placeholder for DOBERO legal compliance work.', 'es' => 'Contenido base de cookies para el trabajo de cumplimiento legal de DOBERO.', 'hu' => 'Cookie-alap tartalom a DOBERO jogi megfelelési munkájához.'],
                'sort_order' => 8,
                'deletable' => false,
            ],
        ];
    }

    public static function settings(): array
    {
        return [
            ['key' => 'legal_owner', 'value' => ['en' => 'János Németh'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'legal_nif', 'value' => ['en' => 'Y1962730Q'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'legal_trade_name', 'value' => ['en' => 'DOBERO'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'legal_activity', 'value' => ['en' => 'Real estate brokerage and real estate services'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'legal_address', 'value' => ['en' => 'urb.Residencial la Torre 28.'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'phone', 'value' => ['en' => '+34 674 920 844'], 'type' => 'text', 'is_translatable' => false],
            ['key' => 'email', 'value' => ['en' => 'info@dobero.es'], 'type' => 'text', 'is_translatable' => false],
        ];
    }
}
