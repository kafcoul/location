<?php<?php



namespace Database\Seeders;namespace Database\Seeders;



use App\Models\City;use App\Models\City;

use App\Models\Vehicle;use App\Models\Vehicle;

use Illuminate\Database\Seeder;use Illuminate\Database\Seeder;



class VehicleSeeder extends Seederclass VehicleSeeder extends Seeder

{{

    public function run(): void    public function run(): void

    {    {

        $abidjan = City::where('slug', 'abidjan')->first();        $abidjan = City::where('slug', 'abidjan')->first();



        $vehicles = [        $vehicles = [

            [            // ─── ABIDJAN ─────────────────────────────

                'city_id'               => $abidjan->id,            [

                'brand'                 => 'TOYOTA',                'city_id'               => $abidjan->id,

                'model'                 => 'LAND CRUISER V8',                'brand'                 => 'TOYOTA',

                'name'                  => 'Toyota Land Cruiser V8',                'model'                 => 'X6 M50D',

                'slug'                  => 'toyota-land-cruiser-v8',                'name'                  => 'BMW X6 M50D',

                'image'                 => 'vehicles/toyota-land-cruiser-v8.jpg',                'slug'                  => 'bmw-x6-m50d',

                'price_per_day'         => 150000,                'price_per_day'         => 350,

                'deposit_amount'        => 500000,                'deposit_amount'        => 7000,

                'km_price'              => 500,                'km_price'              => 1.50,

                'weekly_price'          => 800000,                'weekly_price'          => 1499,

                'monthly_classic_price' => 2500000,                'monthly_classic_price' => 2799,

                'monthly_premium_price' => 3500000,                'monthly_premium_price' => 3999,

                'year'                  => '2023',                'year'                  => '2021',

                'gearbox'               => 'Automatique',                'gearbox'               => 'Automatique',

                'power'                 => '304 ch',                'power'                 => '400 ch',

                'seats'                 => 7,                'seats'                 => 5,

                'fuel'                  => 'Diesel',                'fuel'                  => 'Diesel',

                'carplay'               => true,                'carplay'               => true,

                'description'           => 'Le Toyota Land Cruiser V8 2023 est la référence absolue en matière de robustesse, de fiabilité et de confort tout-terrain. Conçu pour les conditions les plus exigeantes, il offre un luxe inégalé sur toutes les routes d\'Abidjan et au-delà.',                'description'           => 'Découvrez le BMW X6 M50D, un SUV de luxe qui allie une puissance exceptionnelle à un design audacieux et raffiné. Idéal pour ceux qui cherchent à allier élégance et robustesse, le BMW X6 M50D est prêt à vous emmener partout avec style.',

                'details'               => [                'details'               => [

                    'Intérieur' => [                    'Intérieur' => [

                        '7 places (2+3+2), sellerie cuir premium perforé.',                        'Configuration : SUV coupé haut de gamme à 5 places.',

                        'Écran tactile multimédia 12,3″ avec navigation.',                        'Finitions : Finitions M Sport avec sellerie en cuir Vernasca, inserts en aluminium, volant M gainé de cuir, sièges avant massants, chauffants et réglables électriquement.',

                        'Climatisation automatique tri-zone.',                        'Technologies embarquées : Système iDrive avec écran tactile, commandes vocales, compatibilité Apple CarPlay et Android Auto, affichage tête haute, climatisation automatique à 4 zones, système audio Bowers & Wilkins.',

                        'Sièges avant ventilés, chauffants, réglage électrique 14 directions.',                        'Espace intérieur : Volume du coffre de 580 à 1 530 litres avec sièges arrière rabattus.',

                        'Système audio JBL Premium 14 haut-parleurs, Apple CarPlay & Android Auto.',                    ],

                        'Coffre : 259 litres (7 places), 1 131 litres (5 places).',                    'Extérieur' => [

                    ],                        'Design : Lignes dynamiques et athlétiques, calandre avant imposante, jantes en alliage léger de 22 pouces, toit ouvrant panoramique.',

                    'Extérieur' => [                        'Éclairage : Phares à LED adaptatifs, feux arrière à LED, clignotants dynamiques.',

                        'Design : Imposant et robuste, lignes horizontales signature Toyota.',                        'Dimensions : Longueur de 4 935 mm, largeur de 2 004 mm, hauteur de 1 696 mm, empattement de 2 975 mm.',

                        'Jantes alliage 20″, pneus tout-terrain.',                        'Poids : Poids à vide de 2 335 kg, poids total autorisé en charge (PTAC) de 3 010 kg.',

                        'Phares Bi-LED adaptatifs avec lave-phares.',                        'Capacité de remorquage : Poids remorquable freiné de 2 700 kg.',

                        'Dimensions : 4 950 × 1 980 × 1 945 mm, empattement 2 850 mm.',                    ],

                        'Garde au sol : 230 mm, poids à vide : 2 490 kg.',                    'Moteur & performances' => [

                    ],                        'Moteur : 6 cylindres en ligne, 2 993 cm³, injection directe à rampe commune, architecture longitudinale avant.',

                    'Moteur & performances' => [                        'Puissance : 400 ch (294 kW) à 4 400 tr/min.',

                        'Moteur : V6 3,3 L turbo-diesel twin-turbo (F33A-FTV).',                        'Couple : 760 Nm entre 2 000 et 3 000 tr/min.',

                        'Puissance : 304 ch (227 kW) à 4 000 tr/min.',                        'Transmission : Boîte automatique Steptronic à 8 rapports, transmission intégrale xDrive.',

                        'Couple : 700 Nm entre 1 600 et 2 600 tr/min.',                        'Performances : Accélération de 0 à 100 km/h en 5,2 secondes, vitesse maximale limitée électroniquement à 250 km/h.',

                        'Transmission : Boîte automatique Direct Shift à 10 rapports, 4×4 permanent.',                        'Consommation : Cycle mixte de 6,9 à 7,2 l/100 km, émissions de CO₂ de 181 à 190 g/km.',

                        '0–100 km/h : 7,7 s, vitesse maxi : 210 km/h.',                    ],

                        'Consommation mixte : 8,9 l/100 km.',                    'Technologies' => [

                    ],                        'Assistance à la conduite : Système de régulateur de vitesse adaptatif, aide au maintien dans la voie, freinage d\'urgence automatique, alerte de trafic transversal arrière.',

                    'Technologies' => [                        'Connectivité : Application BMW Connected pour la gestion à distance du véhicule, services en ligne intégrés.',

                        'Toyota Safety Sense : freinage d\'urgence, détection piétons/cyclistes.',                        'Sécurité : Système de surveillance des angles morts, caméra de recul avec capteurs de stationnement, système de contrôle de la pression des pneus.',

                        'Multi-Terrain Select : 6 modes de conduite tout-terrain.',                        'Confort : Sièges avant ventilés et massants, climatisation automatique à 4 zones, système audio haut de gamme Bowers & Wilkins.',

                        'Suspension adaptative KDSS (Kinetic Dynamic Suspension System).',                    ],

                        'Caméra 360° Multi-Terrain Monitor.',                ],

                        'Régulateur de vitesse adaptatif, aide au maintien de voie.',                'is_available'          => true,

                    ],            ],

                ],            [

                'is_available'          => true,                'city_id'               => $paris->id,

            ],                'brand'                 => 'BMW',

            [                'model'                 => 'X4 M SPORT',

                'city_id'               => $abidjan->id,                'name'                  => 'BMW X4 M Sport',

                'brand'                 => 'MERCEDES-BENZ',                'slug'                  => 'bmw-x4-m-sport',

                'model'                 => 'GLE 350',                'price_per_day'         => 300,

                'name'                  => 'Mercedes-Benz GLE 350',                'deposit_amount'        => 5000,

                'slug'                  => 'mercedes-gle-350-abidjan',                'km_price'              => 1.50,

                'image'                 => 'vehicles/mercedes-gle-350.jpg',                'weekly_price'          => 1299,

                'price_per_day'         => 120000,                'monthly_classic_price' => 2499,

                'deposit_amount'        => 400000,                'monthly_premium_price' => 3499,

                'km_price'              => 400,                'year'                  => '2022',

                'weekly_price'          => 650000,                'gearbox'               => 'Automatique',

                'monthly_classic_price' => 2000000,                'power'                 => '190 ch',

                'monthly_premium_price' => 3000000,                'seats'                 => 5,

                'year'                  => '2022',                'fuel'                  => 'Diesel',

                'gearbox'               => 'Automatique',                'carplay'               => true,

                'power'                 => '258 ch',                'description'           => 'Le BMW X4 M Sport incarne le parfait équilibre entre dynamisme sportif et élégance moderne. Ce SAC (Sports Activity Coupé) offre une expérience de conduite unique avec ses performances affûtées et son confort haut de gamme.',

                'seats'                 => 5,                'details'               => [

                'fuel'                  => 'Diesel',                    'Intérieur' => [

                'carplay'               => true,                        '5 places avec sellerie cuir Dakota perforé.',

                'description'           => 'Le Mercedes-Benz GLE 350 d 4MATIC est un SUV premium qui conjugue luxe, puissance et polyvalence. Son habitacle raffiné et sa technologie embarquée en font le compagnon idéal pour vos déplacements à Abidjan.',                        'Volant M Sport gainé de cuir avec palettes de changement de vitesse.',

                'details'               => [                        'Tableau de bord BMW Live Cockpit Professional avec écran 12,3″.',

                    'Intérieur' => [                        'Climatisation automatique bi-zone, sièges avant chauffants.',

                        '5 places, sellerie cuir nappa avec surpiqûres.',                        'Système audio HiFi, Apple CarPlay & Android Auto.',

                        'Système MBUX avec double écran 12,3″, commandes vocales « Hey Mercedes ».',                        'Coffre : 525 litres, extensible à 1 430 litres.',

                        'Climatisation automatique THERMOTRONIC 4 zones.',                    ],

                        'Sièges avant à mémoire, chauffants, réglage électrique.',                    'Extérieur' => [

                        'Système audio Burmester® surround, Apple CarPlay & Android Auto.',                        'Ligne coupé sportive, silhouette basse et dynamique.',

                        'Coffre : 630 litres, extensible à 2 055 litres.',                        'Jantes alliage M 20″, finition Cerium Grey.',

                    ],                        'Phares LED adaptatifs, feux arrière en L à LED.',

                    'Extérieur' => [                        'Dimensions : 4 752 × 1 918 × 1 621 mm, empattement 2 864 mm.',

                        'Design : Lignes fluides et musclées, calandre chromée étoilée.',                        'Pack aérodynamique M Sport, double sortie d\'échappement chromée.',

                        'Jantes alliage AMG 20″ multibranches.',                    ],

                        'Phares MULTIBEAM LED adaptatifs.',                    'Moteur & performances' => [

                        'Dimensions : 4 924 × 1 947 × 1 772 mm, empattement 2 935 mm.',                        'Moteur : 4 cylindres en ligne, 1 995 cm³, turbo.',

                        'Pack AMG Line extérieur, barres de toit aluminium.',                        'Puissance : 190 ch (140 kW) à 4 000 tr/min.',

                    ],                        'Couple : 400 Nm entre 1 750 et 2 500 tr/min.',

                    'Moteur & performances' => [                        'Transmission : Boîte automatique Steptronic à 8 rapports, xDrive.',

                        'Moteur : 6 cylindres en ligne, 2 925 cm³, turbo-diesel.',                        '0–100 km/h : 7,7 s, vitesse maxi : 226 km/h.',

                        'Puissance : 258 ch (190 kW) à 3 600 tr/min.',                        'Consommation mixte : 5,8 l/100 km, CO₂ : 153 g/km.',

                        'Couple : 600 Nm entre 1 200 et 3 200 tr/min.',                    ],

                        'Transmission : Boîte automatique 9G-TRONIC, 4MATIC intégrale.',                    'Technologies' => [

                        '0–100 km/h : 6,5 s, vitesse maxi : 230 km/h.',                        'Régulateur de vitesse adaptatif avec fonction Stop & Go.',

                        'Consommation mixte : 7,3 l/100 km, CO₂ : 192 g/km.',                        'Caméra de recul, capteurs de stationnement avant/arrière.',

                    ],                        'Alerte de franchissement de ligne, freinage d\'urgence automatique.',

                    'Technologies' => [                        'BMW Connected Drive, services connectés intégrés.',

                        'Active Brake Assist : freinage d\'urgence automatique.',                        'Affichage tête haute BMW.',

                        'DISTRONIC : régulateur adaptatif avec Stop & Go.',                    ],

                        'Active Steering Assist, Active Lane Keeping Assist.',                ],

                        'Caméra 360°, aide au stationnement automatique PARKTRONIC.',                'is_available'          => true,

                        'Mercedes me Connect, navigation en réalité augmentée.',            ],

                    ],            [

                ],                'city_id'               => $paris->id,

                'is_available'          => true,                'brand'                 => 'AUDI',

            ],                'model'                 => 'Q3 SPORTBACK',

            [                'name'                  => 'Audi Q3 Sportback',

                'city_id'               => $abidjan->id,                'slug'                  => 'audi-q3-sportback',

                'brand'                 => 'LEXUS',                'price_per_day'         => 280,

                'model'                 => 'LX 570',                'deposit_amount'        => 4000,

                'name'                  => 'Lexus LX 570',                'km_price'              => 1.20,

                'slug'                  => 'lexus-lx-570',                'weekly_price'          => 1199,

                'image'                 => 'vehicles/lexus-lx-570.jpg',                'monthly_classic_price' => 2299,

                'price_per_day'         => 180000,                'monthly_premium_price' => 3299,

                'deposit_amount'        => 600000,                'year'                  => '2023',

                'km_price'              => 600,                'gearbox'               => 'Automatique',

                'weekly_price'          => 900000,                'power'                 => '150 ch',

                'monthly_classic_price' => 2800000,                'seats'                 => 5,

                'monthly_premium_price' => 3800000,                'fuel'                  => 'Essence',

                'year'                  => '2023',                'carplay'               => true,

                'gearbox'               => 'Automatique',                'description'           => 'L\'Audi Q3 Sportback 2023 associe le dynamisme d\'un coupé à la polyvalence d\'un SUV compact. Avec sa silhouette sculpturale et ses technologies de pointe, il séduit les conducteurs à la recherche de modernité et de confort.',

                'power'                 => '362 ch',                'details'               => [

                'seats'                 => 7,                    'Intérieur' => [

                'fuel'                  => 'Essence',                        '5 places, sellerie cuir/alcantara S line.',

                'carplay'               => true,                        'Audi Virtual Cockpit 12,3″ + MMI Touch 10,1″.',

                'description'           => 'Le Lexus LX 570 est l\'incarnation du luxe suprême associé à une capacité tout-terrain exceptionnelle. Ce SUV haut de gamme offre un raffinement absolu, une puissance généreuse et un confort de première classe.',                        'Climatisation automatique bi-zone.',

                'details'               => [                        'Sièges sport avant, réglables électriquement.',

                    'Intérieur' => [                        'Système audio Bang & Olufsen 3D, Apple CarPlay & Android Auto.',

                        '7 places (2+3+2), sellerie cuir semi-aniline.',                        'Coffre : 530 litres, extensible à 1 400 litres.',

                        'Écran multimédia 12,3″ avec Remote Touch, navigation.',                    ],

                        'Climatisation automatique 4 zones indépendantes.',                    'Extérieur' => [

                        'Sièges avant ventilés, chauffants, réglage électrique 20 directions.',                        'Ligne coupé arrière plongeante, profil sportif.',

                        'Système audio Mark Levinson® 19 haut-parleurs, Apple CarPlay & Android Auto.',                        'Jantes alliage 19″ design 5 branches.',

                        'Coffre : 300 litres (7 places), 1 200 litres (5 places).',                        'Phares Matrix LED avec clignotants dynamiques.',

                    ],                        'Dimensions : 4 500 × 1 843 × 1 567 mm, empattement 2 680 mm.',

                    'Extérieur' => [                        'Calandre Singleframe octogonale, accents noir brillant.',

                        'Design : Calandre spindle imposante, lignes sculpturales.',                    ],

                        'Jantes alliage 21″ multibranches argent.',                    'Moteur & performances' => [

                        'Phares à triple faisceau LED adaptatifs, feux arrière à LED.',                        'Moteur : 4 cylindres TFSI, 1 498 cm³, turbo.',

                        'Dimensions : 5 080 × 1 980 × 1 910 mm, empattement 2 850 mm.',                        'Puissance : 150 ch (110 kW) à 5 000 tr/min.',

                        'Garde au sol : 225 mm, poids à vide : 2 670 kg.',                        'Couple : 250 Nm entre 1 500 et 3 500 tr/min.',

                    ],                        'Transmission : Boîte S tronic 7 rapports, traction avant.',

                    'Moteur & performances' => [                        '0–100 km/h : 8,8 s, vitesse maxi : 212 km/h.',

                        'Moteur : V8 5,7 L atmosphérique (3UR-FE).',                        'Consommation mixte : 6,1 l/100 km, CO₂ : 139 g/km.',

                        'Puissance : 362 ch (270 kW) à 5 600 tr/min.',                    ],

                        'Couple : 530 Nm à 3 200 tr/min.',                    'Technologies' => [

                        'Transmission : Boîte automatique à 8 rapports, 4×4 permanent.',                        'Audi Pre Sense Front : freinage d\'urgence automatique.',

                        '0–100 km/h : 7,7 s, vitesse maxi : 220 km/h.',                        'Régulateur de vitesse adaptatif, aide au maintien de voie.',

                        'Consommation mixte : 14,4 l/100 km.',                        'Caméra de recul + capteurs de stationnement.',

                    ],                        'Audi Connect : services connectés, navigation en ligne.',

                    'Technologies' => [                        'Audi Smartphone Interface, hotspot Wi-Fi.',

                        'Lexus Safety System+ : freinage pré-collision, détection piétons.',                    ],

                        'Crawl Control : gestion automatique tout-terrain basse vitesse.',                ],

                        'Multi-Terrain Select : 5 modes de conduite.',                'is_available'          => true,

                        'Suspension adaptative AVS (Adaptive Variable Suspension).',            ],

                        'Caméra 360°, aide au stationnement, régulateur adaptatif.',            [

                    ],                'city_id'               => $paris->id,

                ],                'brand'                 => 'MERCEDES-BENZ',

                'is_available'          => true,                'model'                 => 'CLA 200',

            ],                'name'                  => 'Mercedes-Benz CLA 200',

            [                'slug'                  => 'mercedes-benz-cla-200',

                'city_id'               => $abidjan->id,                'price_per_day'         => 250,

                'brand'                 => 'BMW',                'deposit_amount'        => 3500,

                'model'                 => 'X5 XDRIVE',                'km_price'              => 1.00,

                'name'                  => 'BMW X5 xDrive',                'weekly_price'          => 999,

                'slug'                  => 'bmw-x5-xdrive-abidjan',                'monthly_classic_price' => 1999,

                'image'                 => 'vehicles/bmw-x5-xdrive.jpg',                'monthly_premium_price' => 2999,

                'price_per_day'         => 130000,                'year'                  => '2023',

                'deposit_amount'        => 450000,                'gearbox'               => 'Automatique',

                'km_price'              => 450,                'power'                 => '163 ch',

                'weekly_price'          => 700000,                'seats'                 => 5,

                'monthly_classic_price' => 2200000,                'fuel'                  => 'Essence',

                'monthly_premium_price' => 3200000,                'carplay'               => true,

                'year'                  => '2022',                'description'           => 'Le Mercedes-Benz CLA 200 est une berline coupé au design avant-gardiste qui ne laisse personne indifférent. Avec sa ligne basse et aérodynamique, il incarne l\'élégance sportive à l\'état pur.',

                'gearbox'               => 'Automatique',                'details'               => [

                'power'                 => '286 ch',                    'Intérieur' => [

                'seats'                 => 5,                        '5 places, sellerie cuir ARTICO/microfibre DINAMICA.',

                'fuel'                  => 'Diesel',                        'Système MBUX avec double écran 10,25″, commandes vocales « Hey Mercedes ».',

                'carplay'               => true,                        'Climatisation automatique THERMATIC bi-zone.',

                'description'           => 'Le BMW X5 xDrive30d est un SAV (Sports Activity Vehicle) qui repousse les limites du luxe et de la polyvalence. Avec son châssis raffiné et son puissant moteur diesel, il offre une expérience de conduite souveraine sur toutes les routes d\'Abidjan.',                        'Sièges avant chauffants, réglage électrique, mémoire conducteur.',

                'details'               => [                        'Système audio Burmester®, Apple CarPlay & Android Auto sans fil.',

                    'Intérieur' => [                        'Éclairage d\'ambiance LED 64 couleurs.',

                        '5 places, sellerie cuir Vernasca étendu.',                    ],

                        'BMW Live Cockpit Professional : double écran incurvé 12,3″ + 14,9″.',                    'Extérieur' => [

                        'Climatisation automatique 4 zones.',                        'Design : Cx de 0,23, l\'une des berlines les plus aérodynamiques au monde.',

                        'Sièges avant ventilés, chauffants, massants, réglage électrique à mémoire.',                        'Jantes alliage AMG 18″ à 5 branches.',

                        'Système audio Harman Kardon surround, Apple CarPlay & Android Auto.',                        'Phares MULTIBEAM LED avec feux de route adaptatifs.',

                        'Coffre : 650 litres, extensible à 1 870 litres.',                        'Dimensions : 4 688 × 1 830 × 1 439 mm, empattement 2 729 mm.',

                    ],                        'Pack AMG Line : boucliers sportifs, calandre étoilée, double sortie d\'échappement.',

                    'Extérieur' => [                    ],

                        'Design : Silhouette imposante et athlétique, calandre BMW illuminée.',                    'Moteur & performances' => [

                        'Jantes alliage M 22″ bicolores.',                        'Moteur : 4 cylindres en ligne, 1 332 cm³, turbo.',

                        'Phares Laserlight adaptatifs portée 600 m.',                        'Puissance : 163 ch (120 kW) à 5 500 tr/min.',

                        'Dimensions : 4 922 × 2 004 × 1 745 mm, empattement 2 975 mm.',                        'Couple : 250 Nm entre 1 620 et 4 000 tr/min.',

                        'Pack M Sport, accents Shadow Line noir brillant.',                        'Transmission : Boîte automatique DCT 7G à double embrayage.',

                    ],                        '0–100 km/h : 8,0 s, vitesse maxi : 240 km/h.',

                    'Moteur & performances' => [                        'Consommation mixte : 5,7 l/100 km, CO₂ : 131 g/km.',

                        'Moteur : 6 cylindres en ligne, 2 993 cm³, turbo-diesel mild-hybrid 48V.',                    ],

                        'Puissance : 286 ch (210 kW) à 4 000 tr/min.',                    'Technologies' => [

                        'Couple : 650 Nm entre 1 500 et 2 500 tr/min.',                        'Active Brake Assist : freinage d\'urgence automatique piétons/cyclistes.',

                        'Transmission : Boîte automatique Steptronic Sport à 8 rapports, xDrive.',                        'Régulateur de vitesse DISTRONIC, aide au maintien de voie.',

                        '0–100 km/h : 6,1 s, vitesse maxi : 243 km/h.',                        'Caméra 360°, aide au stationnement automatique.',

                        'Consommation mixte : 6,8 l/100 km, CO₂ : 179 g/km.',                        'Mercedes me Connect : services connectés, localisation, diagnostic.',

                    ],                        'Navigation AR avec réalité augmentée.',

                    'Technologies' => [                    ],

                        'Driving Assistant Professional : conduite semi-autonome niveau 2.',                ],

                        'Régulateur adaptatif Stop & Go, changement de voie assisté.',                'is_available'          => true,

                        'Caméra 360° avec vue drone, stationnement automatique.',            ],

                        'BMW Intelligent Personal Assistant : commandes vocales IA.',            [

                        'BMW Connected Drive, Digital Key Plus (iPhone/UWB).',                'city_id'               => $paris->id,

                    ],                'brand'                 => 'VOLKSWAGEN',

                ],                'model'                 => 'GOLF 8 R-LINE',

                'is_available'          => true,                'name'                  => 'Volkswagen Golf 8 R-Line',

            ],                'slug'                  => 'volkswagen-golf-8-r-line',

            [                'price_per_day'         => 200,

                'city_id'               => $abidjan->id,                'deposit_amount'        => 3000,

                'brand'                 => 'SUZUKI',                'km_price'              => 0.80,

                'model'                 => 'FRONX',                'weekly_price'          => 899,

                'name'                  => 'Suzuki Fronx',                'monthly_classic_price' => 1799,

                'slug'                  => 'suzuki-fronx',                'monthly_premium_price' => 2499,

                'image'                 => 'vehicles/suzuki-fronx.jpg',                'year'                  => '2022',

                'price_per_day'         => 45000,                'gearbox'               => 'Automatique',

                'deposit_amount'        => 150000,                'power'                 => '150 ch',

                'km_price'              => 200,                'seats'                 => 5,

                'weekly_price'          => 250000,                'fuel'                  => 'Essence',

                'monthly_classic_price' => 800000,                'carplay'               => true,

                'monthly_premium_price' => 1200000,                'description'           => 'Découvrez l\'essence même de l\'innovation et de l\'élégance avec la Volkswagen Golf 8 R-Line, une compacte sportive qui transcende les frontières du style et de la performance. Tel un véritable visionnaire sur roues, la Golf 8 se révèle comme l\'allié parfait pour surmonter tous les défis qui se dresseront sur votre route.',

                'year'                  => '2024',                'details'               => [

                'gearbox'               => 'Automatique',                    'Intérieur' => [

                'power'                 => '100 ch',                        'Configuration : 5 places',

                'seats'                 => 5,                        "Dimensions :\nLongueur : 4,28 m\nLargeur : 1,79 m\nHauteur : 1,46 m\nEmpattement : 2,64 m",

                'fuel'                  => 'Essence',                        "Volume du coffre :\n381 litres\nVolume utile maximal avec sièges arrière rabattus : 1 237 litres",

                'carplay'               => true,                        "Confort et commodités :\nSellerie spécifique R-Line\nVolant sport multifonctions\nClimatisation automatique bi-zone\nÉclairage d'ambiance personnalisable\nSystème d'infodivertissement avec écran tactile\nConnectivité Apple CarPlay et Android Auto\nPorts USB-C\nToit panoramique ouvrant",

                'description'           => 'Le Suzuki Fronx 2024 est un SUV compact au design audacieux, parfait pour la ville comme pour les escapades. Avec son allure sportive, ses technologies connectées et sa consommation maîtrisée, il est le compagnon idéal pour vos déplacements quotidiens à Abidjan.',                    ],

                'details'               => [                    'Extérieur' => [

                    'Intérieur' => [                        "Design :\nPare-chocs avant et arrière spécifiques R-Line\nCalandre noire brillante\nJantes en alliage de 18 pouces\nFeux arrière à LED avec signature lumineuse\nÉléments chromés discrets",

                        '5 places, sellerie tissu/cuir synthétique bicolore.',                        "Dimensions :\nLongueur : 4,28 m\nLargeur : 1,79 m\nHauteur : 1,46 m\nEmpattement : 2,64 m",

                        'Écran tactile multimédia 9″ SmartPlay Pro+.',                    ],

                        'Climatisation automatique.',                    'Moteur' => [

                        'Sièges avant réglables en hauteur, volant multifonction gainé cuir.',                        'Architecture : 4 cylindres en ligne, turbocompresseur, 16 soupapes (double ACT), injection directe TSI Evo',

                        'Système audio 6 haut-parleurs, Apple CarPlay & Android Auto sans fil.',                        'Cylindrée : 1 498 cm³ (alésage 74,5 mm × course 85,9 mm)',

                        'Coffre : 308 litres.',                        'Rapport de compression : 10,5 :1',

                    ],                        'Puissance : 150 ch (110 kW) à 5 000 tr/min',

                    'Extérieur' => [                        'Couple maxi : 250 Nm à 1 500–3 500 tr/min',

                        'Design : Lignes coupé dynamiques, silhouette sportive et compacte.',                        'Boîte de vitesses : DSG 7 rapports',

                        'Jantes alliage 16″ diamantées bicolores.',                        'Transmission : traction avant',

                        'Phares LED projecteurs avec feux de jour LED en C.',                        "Performances :\n0–100 km/h en ≈ 8,3 s\nVitesse maxi ≈ 224 km/h",

                        'Dimensions : 3 995 × 1 765 × 1 550 mm, empattement 2 520 mm.',                        'Consommation WLTP combinée : 5,4 L/100 km',

                        'Toit flottant noir, barres de toit intégrées.',                        'Émissions de CO₂ WLTP : 124 g/km',

                    ],                    ],

                    'Moteur & performances' => [                    'Technologies' => [

                        'Moteur : 3 cylindres Boosterjet turbo, 998 cm³.',                        "Systèmes d'assistance à la conduite :\nRégulateur de vitesse adaptatif (ACC)\nAssistant de maintien dans la voie (Lane Assist)\nAssistant de freinage d'urgence (Front Assist)\nDétecteur d'angles morts (Side Assist)\nAlerte de circulation transversale arrière\nSystème de freinage automatique post-collision",

                        'Puissance : 100 ch (74 kW) à 5 500 tr/min.',                        "Connectivité et infotainment :\nSystème de navigation avec cartographie en ligne\nConnectivité sans fil Apple CarPlay et Android Auto\nChargeur sans fil pour smartphone\nQuatre ports USB\nApplication mobile VW Connect pour la gestion à distance",

                        'Couple : 148 Nm entre 1 700 et 4 000 tr/min.',                        "Confort et commodités :\nClimatisation automatique bi-zone\nÉclairage d'ambiance personnalisable\nCaméra de recul et capteurs de stationnement\nToit panoramique ouvrant\nSystème audio Harman Kardon",

                        'Transmission : Boîte automatique à 6 rapports.',                    ],

                        '0–100 km/h : 10,0 s, vitesse maxi : 190 km/h.',                ],

                        'Consommation mixte : 5,0 l/100 km, CO₂ : 114 g/km.',                'is_available'          => true,

                    ],            ],

                    'Technologies' => [            [

                        'Suzuki Safety Support : freinage d\'urgence automatique, détection piétons.',                'city_id'               => $paris->id,

                        'Alerte de franchissement de voie, reconnaissance des panneaux.',                'brand'                 => 'AUDI',

                        'Caméra de recul avec lignes de guidage dynamiques.',                'model'                 => 'A1 S-LINE',

                        'Régulateur de vitesse adaptatif.',                'name'                  => 'Audi A1 S-Line',

                        'Affichage tête haute (HUD) couleur.',                'slug'                  => 'audi-a1-s-line',

                    ],                'price_per_day'         => 150,

                ],                'deposit_amount'        => 2000,

                'is_available'          => true,                'km_price'              => 0.60,

            ],                'weekly_price'          => 699,

        ];                'monthly_classic_price' => 1399,

                'monthly_premium_price' => 1999,

        foreach ($vehicles as $v) {                'year'                  => '2022',

            Vehicle::updateOrCreate(['slug' => $v['slug']], $v);                'gearbox'               => 'Automatique',

        }                'power'                 => '116 ch',

    }                'seats'                 => 4,

}                'fuel'                  => 'Essence',

                'carplay'               => true,
                'description'           => 'L\'Audi A1 S-Line est une citadine premium au caractère bien trempé. Compacte mais raffinée, elle offre le meilleur de la technologie Audi dans un format urbain, idéal pour se faufiler en ville avec style.',
                'details'               => [
                    'Intérieur' => [
                        '4 places, sellerie sport tissu/cuir S line.',
                        'Audi Virtual Cockpit 10,25″ + MMI Radio Plus 8,8″.',
                        'Climatisation automatique mono-zone.',
                        'Sièges sport avant S line, réglage manuel.',
                        'Système audio, Audi Smartphone Interface (Apple CarPlay & Android Auto).',
                        'Coffre : 335 litres, extensible à 1 090 litres.',
                    ],
                    'Extérieur' => [
                        'Design : Silhouette compacte et sportive, profil dynamique.',
                        'Jantes alliage 17″ design 5 branches Y, finition argent.',
                        'Phares LED avec feux de jour signature Audi.',
                        'Dimensions : 4 029 × 1 740 × 1 409 mm, empattement 2 563 mm.',
                        'Pack extérieur S line : boucliers sport, diffuseur, accents noir brillant.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : 3 cylindres TFSI, 999 cm³, turbo.',
                        'Puissance : 116 ch (85 kW) à 5 500 tr/min.',
                        'Couple : 200 Nm entre 2 000 et 3 500 tr/min.',
                        'Transmission : Boîte S tronic 7 rapports à double embrayage.',
                        '0–100 km/h : 9,4 s, vitesse maxi : 203 km/h.',
                        'Consommation mixte : 5,0 l/100 km, CO₂ : 114 g/km.',
                    ],
                    'Technologies' => [
                        'Audi Pre Sense Front : freinage d\'urgence automatique.',
                        'Régulateur de vitesse, limiteur de vitesse.',
                        'Caméra de recul + capteurs de stationnement arrière.',
                        'Audi Connect : services connectés basiques.',
                        'Reconnaissance des panneaux de signalisation.',
                    ],
                ],
                'is_available'          => true,
            ],

            // ─── ABIDJAN ─────────────────────────────
            [
                'city_id'               => $abidjan->id,
                'brand'                 => 'TOYOTA',
                'model'                 => 'LAND CRUISER V8',
                'name'                  => 'Toyota Land Cruiser V8',
                'slug'                  => 'toyota-land-cruiser-v8',
                'image'                 => 'vehicles/toyota-land-cruiser-v8.jpg',
                'price_per_day'         => 150000,
                'deposit_amount'        => 500000,
                'km_price'              => 500,
                'weekly_price'          => 800000,
                'monthly_classic_price' => 2500000,
                'monthly_premium_price' => 3500000,
                'year'                  => '2023',
                'gearbox'               => 'Automatique',
                'power'                 => '304 ch',
                'seats'                 => 7,
                'fuel'                  => 'Diesel',
                'carplay'               => true,
                'description'           => 'Le Toyota Land Cruiser V8 2023 est la référence absolue en matière de robustesse, de fiabilité et de confort tout-terrain. Conçu pour les conditions les plus exigeantes, il offre un luxe inégalé sur toutes les routes d\'Abidjan et au-delà.',
                'details'               => [
                    'Intérieur' => [
                        '7 places (2+3+2), sellerie cuir premium perforé.',
                        'Écran tactile multimédia 12,3″ avec navigation.',
                        'Climatisation automatique tri-zone.',
                        'Sièges avant ventilés, chauffants, réglage électrique 14 directions.',
                        'Système audio JBL Premium 14 haut-parleurs, Apple CarPlay & Android Auto.',
                        'Coffre : 259 litres (7 places), 1 131 litres (5 places).',
                    ],
                    'Extérieur' => [
                        'Design : Imposant et robuste, lignes horizontales signature Toyota.',
                        'Jantes alliage 20″, pneus tout-terrain.',
                        'Phares Bi-LED adaptatifs avec lave-phares.',
                        'Dimensions : 4 950 × 1 980 × 1 945 mm, empattement 2 850 mm.',
                        'Garde au sol : 230 mm, poids à vide : 2 490 kg.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : V6 3,3 L turbo-diesel twin-turbo (F33A-FTV).',
                        'Puissance : 304 ch (227 kW) à 4 000 tr/min.',
                        'Couple : 700 Nm entre 1 600 et 2 600 tr/min.',
                        'Transmission : Boîte automatique Direct Shift à 10 rapports, 4×4 permanent.',
                        '0–100 km/h : 7,7 s, vitesse maxi : 210 km/h.',
                        'Consommation mixte : 8,9 l/100 km.',
                    ],
                    'Technologies' => [
                        'Toyota Safety Sense : freinage d\'urgence, détection piétons/cyclistes.',
                        'Multi-Terrain Select : 6 modes de conduite tout-terrain.',
                        'Suspension adaptative KDSS (Kinetic Dynamic Suspension System).',
                        'Caméra 360° Multi-Terrain Monitor.',
                        'Régulateur de vitesse adaptatif, aide au maintien de voie.',
                    ],
                ],
                'is_available'          => true,
            ],
            [
                'city_id'               => $abidjan->id,
                'brand'                 => 'MERCEDES-BENZ',
                'model'                 => 'GLE 350',
                'name'                  => 'Mercedes-Benz GLE 350',
                'slug'                  => 'mercedes-gle-350-abidjan',
                'image'                 => 'vehicles/mercedes-gle-350.jpg',
                'price_per_day'         => 120000,
                'deposit_amount'        => 400000,
                'km_price'              => 400,
                'weekly_price'          => 650000,
                'monthly_classic_price' => 2000000,
                'monthly_premium_price' => 3000000,
                'year'                  => '2022',
                'gearbox'               => 'Automatique',
                'power'                 => '258 ch',
                'seats'                 => 5,
                'fuel'                  => 'Diesel',
                'carplay'               => true,
                'description'           => 'Le Mercedes-Benz GLE 350 d 4MATIC est un SUV premium qui conjugue luxe, puissance et polyvalence. Son habitacle raffiné et sa technologie embarquée en font le compagnon idéal pour vos déplacements à Abidjan.',
                'details'               => [
                    'Intérieur' => [
                        '5 places, sellerie cuir nappa avec surpiqûres.',
                        'Système MBUX avec double écran 12,3″, commandes vocales « Hey Mercedes ».',
                        'Climatisation automatique THERMOTRONIC 4 zones.',
                        'Sièges avant à mémoire, chauffants, réglage électrique.',
                        'Système audio Burmester® surround, Apple CarPlay & Android Auto.',
                        'Coffre : 630 litres, extensible à 2 055 litres.',
                    ],
                    'Extérieur' => [
                        'Design : Lignes fluides et musclées, calandre chromée étoilée.',
                        'Jantes alliage AMG 20″ multibranches.',
                        'Phares MULTIBEAM LED adaptatifs.',
                        'Dimensions : 4 924 × 1 947 × 1 772 mm, empattement 2 935 mm.',
                        'Pack AMG Line extérieur, barres de toit aluminium.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : 6 cylindres en ligne, 2 925 cm³, turbo-diesel.',
                        'Puissance : 258 ch (190 kW) à 3 600 tr/min.',
                        'Couple : 600 Nm entre 1 200 et 3 200 tr/min.',
                        'Transmission : Boîte automatique 9G-TRONIC, 4MATIC intégrale.',
                        '0–100 km/h : 6,5 s, vitesse maxi : 230 km/h.',
                        'Consommation mixte : 7,3 l/100 km, CO₂ : 192 g/km.',
                    ],
                    'Technologies' => [
                        'Active Brake Assist : freinage d\'urgence automatique.',
                        'DISTRONIC : régulateur adaptatif avec Stop & Go.',
                        'Active Steering Assist, Active Lane Keeping Assist.',
                        'Caméra 360°, aide au stationnement automatique PARKTRONIC.',
                        'Mercedes me Connect, navigation en réalité augmentée.',
                    ],
                ],
                'is_available'          => true,
            ],
            [
                'city_id'               => $abidjan->id,
                'brand'                 => 'LEXUS',
                'model'                 => 'LX 570',
                'name'                  => 'Lexus LX 570',
                'slug'                  => 'lexus-lx-570',
                'image'                 => 'vehicles/lexus-lx-570.jpg',
                'price_per_day'         => 180000,
                'deposit_amount'        => 600000,
                'km_price'              => 600,
                'weekly_price'          => 900000,
                'monthly_classic_price' => 2800000,
                'monthly_premium_price' => 3800000,
                'year'                  => '2023',
                'gearbox'               => 'Automatique',
                'power'                 => '362 ch',
                'seats'                 => 7,
                'fuel'                  => 'Essence',
                'carplay'               => true,
                'description'           => 'Le Lexus LX 570 est l\'incarnation du luxe suprême associé à une capacité tout-terrain exceptionnelle. Ce SUV haut de gamme offre un raffinement absolu, une puissance généreuse et un confort de première classe.',
                'details'               => [
                    'Intérieur' => [
                        '7 places (2+3+2), sellerie cuir semi-aniline.',
                        'Écran multimédia 12,3″ avec Remote Touch, navigation.',
                        'Climatisation automatique 4 zones indépendantes.',
                        'Sièges avant ventilés, chauffants, réglage électrique 20 directions.',
                        'Système audio Mark Levinson® 19 haut-parleurs, Apple CarPlay & Android Auto.',
                        'Coffre : 300 litres (7 places), 1 200 litres (5 places).',
                    ],
                    'Extérieur' => [
                        'Design : Calandre spindle imposante, lignes sculpturales.',
                        'Jantes alliage 21″ multibranches argent.',
                        'Phares à triple faisceau LED adaptatifs, feux arrière à LED.',
                        'Dimensions : 5 080 × 1 980 × 1 910 mm, empattement 2 850 mm.',
                        'Garde au sol : 225 mm, poids à vide : 2 670 kg.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : V8 5,7 L atmosphérique (3UR-FE).',
                        'Puissance : 362 ch (270 kW) à 5 600 tr/min.',
                        'Couple : 530 Nm à 3 200 tr/min.',
                        'Transmission : Boîte automatique à 8 rapports, 4×4 permanent.',
                        '0–100 km/h : 7,7 s, vitesse maxi : 220 km/h.',
                        'Consommation mixte : 14,4 l/100 km.',
                    ],
                    'Technologies' => [
                        'Lexus Safety System+ : freinage pré-collision, détection piétons.',
                        'Crawl Control : gestion automatique tout-terrain basse vitesse.',
                        'Multi-Terrain Select : 5 modes de conduite.',
                        'Suspension adaptative AVS (Adaptive Variable Suspension).',
                        'Caméra 360°, aide au stationnement, régulateur adaptatif.',
                    ],
                ],
                'is_available'          => true,
            ],
            [
                'city_id'               => $abidjan->id,
                'brand'                 => 'BMW',
                'model'                 => 'X5 XDRIVE',
                'name'                  => 'BMW X5 xDrive',
                'slug'                  => 'bmw-x5-xdrive-abidjan',
                'image'                 => 'vehicles/bmw-x5-xdrive.jpg',
                'price_per_day'         => 130000,
                'deposit_amount'        => 450000,
                'km_price'              => 450,
                'weekly_price'          => 700000,
                'monthly_classic_price' => 2200000,
                'monthly_premium_price' => 3200000,
                'year'                  => '2022',
                'gearbox'               => 'Automatique',
                'power'                 => '286 ch',
                'seats'                 => 5,
                'fuel'                  => 'Diesel',
                'carplay'               => true,
                'description'           => 'Le BMW X5 xDrive30d est un SAV (Sports Activity Vehicle) qui repousse les limites du luxe et de la polyvalence. Avec son châssis raffiné et son puissant moteur diesel, il offre une expérience de conduite souveraine sur toutes les routes d\'Abidjan.',
                'details'               => [
                    'Intérieur' => [
                        '5 places, sellerie cuir Vernasca étendu.',
                        'BMW Live Cockpit Professional : double écran incurvé 12,3″ + 14,9″.',
                        'Climatisation automatique 4 zones.',
                        'Sièges avant ventilés, chauffants, massants, réglage électrique à mémoire.',
                        'Système audio Harman Kardon surround, Apple CarPlay & Android Auto.',
                        'Coffre : 650 litres, extensible à 1 870 litres.',
                    ],
                    'Extérieur' => [
                        'Design : Silhouette imposante et athlétique, calandre BMW illuminée.',
                        'Jantes alliage M 22″ bicolores.',
                        'Phares Laserlight adaptatifs portée 600 m.',
                        'Dimensions : 4 922 × 2 004 × 1 745 mm, empattement 2 975 mm.',
                        'Pack M Sport, accents Shadow Line noir brillant.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : 6 cylindres en ligne, 2 993 cm³, turbo-diesel mild-hybrid 48V.',
                        'Puissance : 286 ch (210 kW) à 4 000 tr/min.',
                        'Couple : 650 Nm entre 1 500 et 2 500 tr/min.',
                        'Transmission : Boîte automatique Steptronic Sport à 8 rapports, xDrive.',
                        '0–100 km/h : 6,1 s, vitesse maxi : 243 km/h.',
                        'Consommation mixte : 6,8 l/100 km, CO₂ : 179 g/km.',
                    ],
                    'Technologies' => [
                        'Driving Assistant Professional : conduite semi-autonome niveau 2.',
                        'Régulateur adaptatif Stop & Go, changement de voie assisté.',
                        'Caméra 360° avec vue drone, stationnement automatique.',
                        'BMW Intelligent Personal Assistant : commandes vocales IA.',
                        'BMW Connected Drive, Digital Key Plus (iPhone/UWB).',
                    ],
                ],
                'is_available'          => true,
            ],
            [
                'city_id'               => $abidjan->id,
                'brand'                 => 'SUZUKI',
                'model'                 => 'FRONX',
                'name'                  => 'Suzuki Fronx',
                'slug'                  => 'suzuki-fronx',
                'image'                 => 'vehicles/suzuki-fronx.jpg',
                'price_per_day'         => 45000,
                'deposit_amount'        => 150000,
                'km_price'              => 200,
                'weekly_price'          => 250000,
                'monthly_classic_price' => 800000,
                'monthly_premium_price' => 1200000,
                'year'                  => '2024',
                'gearbox'               => 'Automatique',
                'power'                 => '100 ch',
                'seats'                 => 5,
                'fuel'                  => 'Essence',
                'carplay'               => true,
                'description'           => 'Le Suzuki Fronx 2024 est un SUV compact au design audacieux, parfait pour la ville comme pour les escapades. Avec son allure sportive, ses technologies connectées et sa consommation maîtrisée, il est le compagnon idéal pour vos déplacements quotidiens à Abidjan.',
                'details'               => [
                    'Intérieur' => [
                        '5 places, sellerie tissu/cuir synthétique bicolore.',
                        'Écran tactile multimédia 9″ SmartPlay Pro+.',
                        'Climatisation automatique.',
                        'Sièges avant réglables en hauteur, volant multifonction gainé cuir.',
                        'Système audio 6 haut-parleurs, Apple CarPlay & Android Auto sans fil.',
                        'Coffre : 308 litres.',
                    ],
                    'Extérieur' => [
                        'Design : Lignes coupé dynamiques, silhouette sportive et compacte.',
                        'Jantes alliage 16″ diamantées bicolores.',
                        'Phares LED projecteurs avec feux de jour LED en C.',
                        'Dimensions : 3 995 × 1 765 × 1 550 mm, empattement 2 520 mm.',
                        'Toit flottant noir, barres de toit intégrées.',
                    ],
                    'Moteur & performances' => [
                        'Moteur : 3 cylindres Boosterjet turbo, 998 cm³.',
                        'Puissance : 100 ch (74 kW) à 5 500 tr/min.',
                        'Couple : 148 Nm entre 1 700 et 4 000 tr/min.',
                        'Transmission : Boîte automatique à 6 rapports.',
                        '0–100 km/h : 10,0 s, vitesse maxi : 190 km/h.',
                        'Consommation mixte : 5,0 l/100 km, CO₂ : 114 g/km.',
                    ],
                    'Technologies' => [
                        'Suzuki Safety Support : freinage d\'urgence automatique, détection piétons.',
                        'Alerte de franchissement de voie, reconnaissance des panneaux.',
                        'Caméra de recul avec lignes de guidage dynamiques.',
                        'Régulateur de vitesse adaptatif.',
                        'Affichage tête haute (HUD) couleur.',
                    ],
                ],
                'is_available'          => true,
            ],
        ];

        foreach ($vehicles as $v) {
            Vehicle::updateOrCreate(['slug' => $v['slug']], $v);
        }
    }
}
