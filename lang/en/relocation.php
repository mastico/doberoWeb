<?php

return [

    'title'       => 'Relocation',
    'subtitle'    => 'DOBERO',
    'description' => 'Your step-by-step guide to settling in Spain on the Costa Blanca.',
    'nav_label'   => 'Quick Navigation',

    'nav' => [
        'notary'            => 'Power of Attorney',
        'nie'               => 'NIE Number',
        'bank'              => 'Opening Bank Account',
        'address'           => 'Empadronamiento (Address Registration)',
        'residency'         => 'European Residence in Spain',
        'digital-signature' => 'Digital Signature',
        'transcript'        => 'Utility Transfer',
    ],

    'notary' => [
        'title'     => 'Power of Attorney',
        'intro'     => 'A power of attorney between a home buyer and their representative gives the latter the legal authority to act on behalf of the buyer in all matters relating to the sale of the property. The buyer delegates their authority to the representative to perform certain actions in their place.',
        'h_uses'    => 'What is it used for when buying a home?',
        'uses'      => [
            '<strong>If the buyer resides abroad:</strong> The power of attorney allows a representative in Spain to manage all procedures, without the buyer having to travel constantly.',
            '<strong>If the buyer cannot be present:</strong> Due to work, illness or other circumstances, the power of attorney allows their representative to act on their behalf.',
            '<strong>To speed up the process:</strong> A representative with a power of attorney can make decisions and take action without the need for constant approval.',
            '<strong>For added security:</strong> The buyer may prefer to have a lawyer or property manager handle the sale to ensure everything is done correctly according to the law.',
        ],
        'h_actions' => 'Actions the representative can perform',
        'actions'   => [
            'Signing contracts on behalf of the buyer',
            'Managing the mortgage or any other type of financing',
            'Making the necessary payments on behalf of the buyer',
            'Managing the necessary documentation for the sale',
            'Attending appointments with the seller, the notary, etc.',
        ],
        'note' => 'The power of attorney must be granted before a notary and must clearly specify the representative\'s powers. A poorly drafted power of attorney can lead to legal problems. Consult a lawyer to ensure it covers all the buyer\'s needs.',
    ],

    'nie' => [
        'title' => 'NIE Number',
        'badge' => '24–48h',
        'intro' => 'The <strong>Foreigner Identification Number (NIE)</strong> is a tax identification code assigned to foreign citizens who reside in Spain or need to carry out legal or administrative procedures there. It is the equivalent of the Tax Identification Number (NIF) for Spaniards, but for foreigners.',
        'h_uses' => 'What is the NIE for?',
        'uses'   => [
            'Buying or selling a property — essential for any real estate transaction',
            'Opening a bank account — most banks require a NIE',
            'Working in Spain — required for employment contracts and Social Security',
            'Driving in Spain — to obtain or renew a driving licence',
            'Obtaining a health card — to access the public health system',
            'Enrolling in university or school',
            'Setting up a company or registering a business',
            'Filing tax returns',
            'Obtaining a visa or residence permit',
        ],
        'note' => 'The NIE is an essential document for any foreigner who wants to live, work, or carry out legal procedures in Spain. DOBERO can process your NIE within 24–48 hours.',
    ],

    'bank' => [
        'title'       => 'Opening Bank Account',
        'intro'       => 'A bank account in Spain is essential for foreigners with residency to fully integrate into daily life. It enables a wide range of financial transactions and management tasks.',
        'h_uses'      => 'What can you do with a Spanish bank account?',
        'uses'        => [
            'Receive your salary directly into your account',
            'Pay taxes — both national and regional',
            'Pay utility bills (electricity, water, gas, internet, rent)',
            'Make online purchases safely',
            'Receive international transfers from family or friends',
            'Manage savings and investments in Spain',
            'Receive social benefits you may be entitled to',
            'Use debit and credit cards at ATMs and businesses',
            'Pay with Bizum — Spain\'s quick peer-to-peer payment app',
        ],
        'h_important' => 'Important things to know',
        'important'   => [
            '<strong>Required documentation:</strong> NIE, passport or ID card, and possibly proof of address',
            '<strong>Residency requirements:</strong> Some banks may require a minimum period of residence',
            '<strong>Fees:</strong> Compare account maintenance fees, transfer costs, and card fees across banks',
            '<strong>Taxes:</strong> Interest on savings may be subject to Spanish tax',
            '<strong>Language:</strong> Many banks offer English services; basic Spanish knowledge is helpful',
        ],
    ],

    'address' => [
        'title'      => 'Empadronamiento (Address Registration)',
        'intro'      => '<strong>Empadronamiento</strong> is the administrative registration of inhabitants in a Spanish municipality — the official registry proving that a person resides in a specific place. It is a municipal (not state) registry.',
        'h_required' => 'What is it required for?',
        'required'   => [
            'Obtaining a health card — to access public healthcare',
            'Enrolling children in schools or institutes',
            'Applying for social assistance and city council subsidies',
            'Obtaining or renewing a driving licence (in some cases)',
            'Processing residency in Spain',
            'Voting in municipal elections',
            'A wide variety of other municipal administrative procedures',
        ],
        'h_how' => 'How to register',
        'how'   => [
            'Go to the <strong>town hall (ayuntamiento)</strong> of the municipality where you reside',
            'Fill out the registration application form',
            'Present your DNI/NIE and passport, plus proof of address (rental contract or utility bill)',
            'Receive your registration certificate (certificate can often be requested online)',
        ],
        'note' => 'The registration certificate has no specific expiration date, but some agencies require a recent certificate (less than 3 months old). Always update your registration if you change address.',
    ],

    'residency' => [
        'title'       => 'European Residence in Spain',
        'intro'       => 'The <strong>European Residence certificate</strong> is issued to citizens of the EU, EEA, or Switzerland who live in Spain for more than three months. It is not a special visa, but official proof of legal residence.',
        'h_enables'   => 'What the EU residence card enables',
        'enables'     => [
            'Access to the Spanish job market',
            'Access to public healthcare and education',
            'Opening bank accounts',
            'Applying for other permits and licences',
            'Proving your address for administrative matters',
        ],
        'h_mandatory' => 'Is it mandatory?',
        'mandatory'   => 'If you stay in Spain longer than three months, you must register as a resident. The physical card is not strictly mandatory, but it is the easiest and most practical way to prove your legal residence.',
        'h_docs'      => 'Required documents',
        'docs'        => [
            'Valid passport or national ID',
            'Completed application form',
            'Proof of address in Spain (e.g., rental contract)',
            'Recent photograph',
            'Payment of the relevant fee',
        ],
        'note' => 'You apply at the Immigration Office in your province of residence. Fees are usually low — check locally for updated costs and procedures.',
    ],

    'digital_signature' => [
        'title'     => 'Digital Signature',
        'intro'     => 'A <strong>digital signature</strong> guarantees the authenticity, integrity, and non-repudiation of an electronic document. It confirms the document has not been altered and was signed by the claimed person. Unlike a scanned handwritten signature, it provides much higher security and full legal validity.',
        'h_uses'    => 'Common uses',
        'uses'      => [
            'Signing online contracts',
            'Filing tax returns with the Spanish Tax Agency (Agencia Tributaria)',
            'Signing official administrative documents',
            'Authorizing financial transactions',
            'Securing electronic communications',
            'Accessing secure government systems',
        ],
        'h_stored'  => 'Where is it stored?',
        'stored'    => [
            '<strong>Hardware token (USB or smart card)</strong> — most secure option',
            '<strong>Certificate software on a computer</strong> — convenient but less secure',
        ],
        'h_managed' => 'Who manages it?',
        'managed'   => 'The user is responsible for protecting their private key. A Certification Authority (CA) issues and manages the certificate but does not store the private key.',
        'note' => 'Digital signatures ensure secure and legally valid electronic transactions in Spain. Handle your certificate responsibly — losing your private key may require reissuing the certificate.',
    ],

    'transcript' => [
        'title' => 'Utility Transfer',
        'intro' => 'A <strong>utility transfer</strong> (sometimes called utility transcription) refers to changing utility contracts — electricity, water, and gas — into the new owner\'s name after buying a property.',
        'h_why' => 'Why it matters',
        'why'   => [
            'Bills are issued in the new owner\'s name',
            'Legal responsibility for payments is properly transferred',
            'Services continue without interruption after the purchase',
        ],
        'h_docs' => 'What you need to provide',
        'docs'   => [
            'Your ID or NIE number',
            'Property details (address, cadastral reference)',
            'Bank account number (IBAN) for direct debit',
            'A copy of the purchase deed (<em>escritura</em>)',
        ],
        'note' => 'This is a simple but important step immediately after completing the property purchase. DOBERO handles utility transfers as part of our post-sale support service.',
    ],
];
