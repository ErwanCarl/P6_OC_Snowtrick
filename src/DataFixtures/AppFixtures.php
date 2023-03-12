<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\Picture;
use App\Entity\Snowtrick;
use App\Entity\TrickGroup;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $slugger;
    private $userPasswordHasher;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->slugger = $slugger;
        $this->userPasswordHasher = $userPasswordHasherInterface;
    }

    public function getUserData() : User 
    {
        $user = new User();
        $user 
            ->setNickname('Jérémie')
            ->setName('Martin')
            ->setMail('jeremie.martin@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setIsVerified(true)
            ->setLogo('flower.png')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'Jeremie34090!'));

        return $user;
    }
    
    public function getSnowtrickData(): array
    {
        $group1 = new TrickGroup();
        $group1->setLabel('Facile');

        $group2 = new TrickGroup();
        $group2->setLabel('Intermédiaire');

        $group3 = new TrickGroup();
        $group3->setLabel('Difficile');

        $group4 = new TrickGroup();
        $group4->setLabel('Extrême');

        $tricks = [
            [
                'Backside Air',
                'Jéremie Martin',
                "Beaucoup considèrent le backside air comme LE trick emblématique du snowboard. Nous faisons partie de ceux-là, et du coup on t’offre (non ne nous remercie pas c’est cadeau!) la liste de nos Backside airs préférés (de tous les temps).

                Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus.",
                $group4,
                'backsideair.jpg',
                'https://www.youtube.com/watch?v=h0UtyOX9p90&ab_channel=AndreaPadovani',
                'h0UtyOX9p90'
            ],
            [
                'One Foot Tricks',
                'Jéremie Martin',
                "Bode Merril est la preuve vivante que la réincarnation n’est pas un conte de fée. Dans sa vie antérieure de flamant rose, il avait déjà l’habitude d’affronter le quotidien sur une patte. Quelque 200 ans plus tard, il a eu la chance d’être un homme doté d’un snowboard, ce qui a fini par donner à son être l’élan nécessaire. Il aime bien s’avaler quelques one foot double backflips au p’tit déj.",
                $group1,
                'one-foot-tricks.jpg',
                'https://www.youtube.com/watch?v=yK5GFfqeYfU&ab_channel=RedBullSnow',
                'yK5GFfqeYfU'
            ],
            [
                'Switch Backside',
                'Jéremie Martin',
                "Si l’univers du snowboard a jamais disposé d’un scientifique, alors c’était David Benedek. Personne mieux que lui n’a su comment monter un kicker pour qu’un trick marche bien. En musique, on qualifie cela d’expérimental. Ce n’est pas un hasard si c’est précisément lui qui a eu l’idée de faire un switch BS rodeo.",
                $group3,
                'switch-backside.jpg',
                'https://www.youtube.com/watch?v=BH42KlQ0QsE&ab_channel=eugvvo',
                'BH42KlQ0QsE'
            ],
            [
                'BS 540 Seatbelt',
                'Jéremie Martin',
                "Hitsch aurait tout aussi bien pu faire de la danse classique mais il s’est décidé pour la neige. Peut-être tout simplement parce qu’en Engadine, les montagnes sont plus séduisantes que les gymnases. Quoi qu’il en soit, quiconque arrive à attraper aussi tranquillement l’arrière de la planche avec la main avant pendant un BS 5 dans un half-pipe sans s’ouvrir les lèvres sur le coping devrait occuper une chaire à Cambridge sur les prodiges de la coordination.",
                $group4,
                'bs-540-seatbelt.jpg',
                'https://www.youtube.com/watch?v=cdekJgZs9qY&ab_channel=SnowboardAddiction',
                'cdekJgZs9qY'
            ],
            [
                'FS 720 Japan',
                'Jéremie Martin',
                "Si, dans le monde du snowboard, il y avait aujourd’hui encore quelque chose de comparable au rock’n’roll, Ben Ferguson en serait le Jim Morrison, haut la main. Son riding est radical, sans compromis et beau à voir. Bien entendu, rien ne se fait à moins de 200 km/h, pas même les FS 7 Japan dans le pipe.",
                $group3,
                'FS720Japan.jpg',
                'https://www.youtube.com/watch?v=XkkUSEz3I00&ab_channel=SnowboarderMagazine',
                'XkkUSEz3I00'
            ],
            [
                'Skate Skills',
                'Jéremie Martin',
                "Scott «MacGyver» Stevens n’aurait en fait pas besoin de forfait de remontée. Scott n’aurait même pas besoin d’aller à la montagne. Scott a juste à sortir de chez lui, respirer un bon coup et démarrer. Après trois jours de tournage, son rôle serait plus long et plus créatif que pour ceux qui ont dû passer 20 heures en avion, 10 heures en voiture, 5 heures en Ski-Doo et 2 heures en hélicoptère pour leur séquence.",
                $group1,
                'skateskills.jpg',
                'https://www.youtube.com/watch?v=2RlDSbxsnyc&ab_channel=RedBullSnow',
                '2RlDSbxsnyc'
            ],
            [
                'Switch Method',
                'Jéremie Martin',
                "Danny Davis est comme ces meilleurs potes qui peuvent faire tous les tricks avec juste un tout petit plus de classe que toi. Aussi difficiles ou aussi faciles soient-ils. Si un nombre incalculable de blessures ne l’avait pas cloué au lit, il aurait mis sens dessus dessous le monde de la compétition en pipe. Heureusement qu’il y a la vidéo. Et puis on peut quand même se faire une compétition de temps en temps. Et alors on peut y mettre un peu de switch method pour faire tomber les juges à la renverse.",
                $group2,
                'switch-method.jpg',
                'https://www.youtube.com/watch?v=szW8xTlpaAw&ab_channel=SnowboarderMagazine',
                'szW8xTlpaAw'
            ],
            [
                'Going bigger',
                'Jéremie Martin',
                "Soyons francs, tous les tricks de Travis pourraient être des signatures. Son genre «I go bigger» se voit probablement dès le matin aux toilettes. Trois fois par dessus la tête ou simply straight, il semble que Travis puisse à peu près tout essayer plus haut, plus loin, plus extrême, plus beau et en premier la plupart du temps.",
                $group2,
                'going-bigger.jpg',
                'https://www.youtube.com/watch?v=wlEY-D2F6Yk&ab_channel=NetworkA',
                'wlEY-D2F6Yk'
            ],
            [
                'McTwist',
                'Jéremie Martin',
                "Terje se sent mieux dans les transitions que Trump dans sa tour. Pas étonnant, il a détenu pendant longtemps le record du highest air. En mars 2007 à Oslo, il s’est catapulté à un bon 9,8 mètres sur un quarterpipe. Pendant le saut, l’altitude l’a surpris lui-même, c’est pourquoi il a rapidement transformé la méthode prévue en un BS 360. Pourquoi se priver quand on peut. Les McTwists dans un half-pipe par contre c’est plutôt comme une fête d’anniversaire. On a besoin d’un peu d’alley-oop et de chicken wings pour trouver le frisson.",
                $group3,
                'mctwist.jpg',
                'https://www.youtube.com/watch?v=YQIvm_2ay-U&ab_channel=RedBull',
                'YQIvm_2ay-U'
            ],
            [
                'Buttered Tricks',
                'Jéremie Martin',
                "Que faire quand passer les kickers devient monotone? Facile, on rend l’approche plus difficile. C’est du moins ce que s’est dit Jussi quand il a filmé son rôle pour Afterbang (Robot Food; 2002). Concrètement, ça veut dire faire du buttering à gogo. Pour Jussi, ce n’est pas vraiment un problème même avant un switch backside 900.",
                $group1,
                'buttered-tricks.jpg',
                'https://www.youtube.com/watch?v=P7NeerMfLq0&ab_channel=SnowboardProCamp',
                'P7NeerMfLq0'
            ],
            [
                'Lobster Flip',
                'Jéremie Martin',
                "Nommer son trick typique d’après sa propre marque de snowboard est plutôt osé. Les mômes regardent la vidéo, se disent «ouaouh», essaient d’imiter l’acrobatie et avant ça vont s’acheter la planche qu’il faut. D’apparence innocent comme un agneau, Halldor est en fait le businessman le plus dur à cuire d’Islande. Tout cela sans le vouloir évidemment.",
                $group3,
                'lobster-flip.jpg',
                'https://www.youtube.com/watch?v=q-RAJnV1dfg&ab_channel=HarryBurns',
                'q-RAJnV1dfg'
            ],
            [
                'Nuckle Tricks',
                'Jéremie Martin',
                "Marcus est né juste avant le millénaire et atteint sa majorité cette année. Quel toupet quand on pense à tous les tricks que ce gamin a déjà sous la ceinture. Qu’est-ce que vont dire ses petits enfants en 2075 quand il leur racontera qu’il a appris à faire ses premier 1080 en atterrissant des kickers? Et qu’est-ce qu’il pourra bien leur raconter sur les 2022? Backside Octa Cork to FS Edgeslide au-dessus de télécabine to Triple FS Rodeo Truck Driver out?",
                $group2,
                'nuckle-tricks.jpg',
                'https://www.youtube.com/watch?v=OlkBw78JIM4&ab_channel=XGames',
                'OlkBw78JIM4'
            ],
            [
                'FS 900',
                'Jéremie Martin',
                "Quand le style est vraiment original, on le reconnaît même dans les tricks banals. Vous en voulez l’exemple parfait? Travis Parker. Il fait un FS 900 (aujourd’hui aussi banal que l’était l’indy il y a 20 ans) depuis la carre front, tient le nose et pendant un instant le monde s’immobilise. Que Travis soit original est de toute manière indiscutable. Qui d’autre annule du jour au lendemain les contrats avec tous ses sponsors pour devenir cuisinier de sushis?",
                $group3,
                'fs900.jpg',
                'https://www.youtube.com/watch?v=IPc7cJHt1rc&ab_channel=JuhoV%C3%A4is%C3%A4nen',
                'IPc7cJHt1rc'
            ],
            [
                'Goofy',
                'Jéremie Martin',
                "Avant toute chose, il faut d’abord connaitre la position qui te convient le mieux sur ton snowboard, car contrairement au ski où tu peux soit skier en avant ou en arrière, la position de descente en snowboard se fait de côté, avec un pied en avant et un autre à l’arrière de la planche. 

                Les deux positions qui existent en snowboard, en surf ou en skateboard sont les mêmes et s'appellent Le Regular et le Goofy. La position Regular signifie que tu descendras la piste avec ton pied gauche au devant de ta planche et ton pied droit à l’arrière. Tandis que la position Goofy est l’inverse : le pied droit en avant et le pied gauche à l’arrière. 
                
                Après avoir trouvé la position qui te convient le mieux, il faut aussi connaitre le mot ‘’Switch’’ ou bien ‘’rider en Switch’’, qui est un terme souvent utilisé dans les snowparks ou dans des compétitions de freestyle à la télé. Lorsqu’on parle d’une position ‘’Switch’’, cela veut dire qu’une personne qui a l’habitude d’être en Regular sur sa planche, a fait un demi-tour sur lui-même pour rider en Goofy avec le pied droit devant. Le même va pour les rideurs Goofy lorsqu’ils descendent en Regular. ",
                $group1,
                'goofy.jpg',
                'https://www.youtube.com/watch?v=2lnZGESa-qQ&ab_channel=SnowboardAddiction',
                '2lnZGESa-qQ'
            ],
            [
                'Ollie',
                'Jéremie Martin',
                "Dès que tu auras perfectionné les Noses Press, les Tails Press et les Butters, tu pourras t’attaquer au Ollie et au Nollie. Le Ollie est l'une des figures fondamentales qu'il faut maîtriser en snowboard, car tu l’utiliseras pour prendre de l’air sur des kickers ou pour sauter sur des rails. 

                Pour faire un Ollie, déplace ton poids sur ta jambe arrière, comme pour les Tails Press, et dans un mouvement rapide, saute en levant ta jambe avant. Puis, avec un peu d'effort, lève également ta jambe arrière, de sorte que tes pieds soient parallèles et que ta planche soit à l'horizontale par rapport au sol. 
                
                Un Nollie se fait sur le Nose de la planche et consiste à déplacer ton poids sur ta jambe avant, puis à sauter depuis ta jambe arrière. Comme pour le Ollie, tu dois ensuite faire monter ta jambe avant pour qu’elle rejoigne ta jambe arrière, ce qui créera un saut en parallèle avec le sol. Plutôt cool, non ?",
                $group1,
                'ollie.jpg',
                'https://www.youtube.com/watch?v=kOyCsY4rBH0&ab_channel=SnowsurfMagazine',
                'kOyCsY4rBH0'
            ],
        ];

        return $tricks;
    }

    public function load(ObjectManager $manager): void
    {        
        $user = $this->getUserData();
        $manager->persist($user);
        $manager->flush();
        
        $snowtricks = $this->getSnowtrickData();
        foreach ($snowtricks as [$title, $author, $content, $trickGroupX, $pictureName, $videoUrl, $videoId]) {
            
            $picture = new Picture();
            $video = new Video();
            $snowtrick = new Snowtrick();

            $picture
                ->setFileName($pictureName)
                ->setSnowtrick($snowtrick)
            ;

            $video
                ->setSnowtrick($snowtrick)
                ->setUrl($videoUrl)
                ->setVideoId($videoId)
            ;

            $snowtrick
                ->setTitle($title)
                ->setAuthor($author)
                ->setSlug(strtolower($this->slugger->slug($title)))
                ->setContent($content)
                ->addPicture($picture)
                ->addVideo($video)
                ->setTrickGroup($trickGroupX)
                ->setUser($user)
            ;
            
            $manager->persist($snowtrick);
            $manager->persist($picture);
            $manager->persist($video);

            $manager->flush();
        }
    } 
}
