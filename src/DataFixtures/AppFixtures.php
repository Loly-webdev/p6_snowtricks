<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * AppFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user     = new User();
        $password = $this->encoder->encodePassword($user, 'now');
        $user->setUsername('Nowhere')
              ->setEmail('eva@gmail.com')
              ->setPassword($password)
              ->setRoles(['ROLE_ADMIN'])
              ->setProfilePicture('nowhere-profile.jpeg')
              ->setCreatedAt(new DateTime())
              ->setIsVerified(1);
        $manager->persist($user);

        $user1     = new User();
        $password = $this->encoder->encodePassword($user1, 'Banner');
        $user1->setUsername('Bruce')
              ->setEmail('bruce_banner@gmail.com')
              ->setPassword($password)
              ->setRoles(['ROLE_USER'])
              ->setProfilePicture('profile-picture-default.jpeg')
              ->setCreatedAt(new DateTime())
              ->setIsVerified(1);
        $manager->persist($user1);

        $user2    = new User();
        $password = $this->encoder->encodePassword($user2, 'kent');
        $user2->setUsername('Clark')
              ->setEmail('clark.kentt@gmail.com')
              ->setPassword($password)
              ->setRoles(['ROLE_USER'])
              ->setProfilePicture('clark-profile.png')
              ->setCreatedAt(new DateTime())
              ->setIsVerified(1);
        $manager->persist($user2);

        $user3    = new User();
        $password = $this->encoder->encodePassword($user3, 'prince');
        $user3->setUsername('Diana')
              ->setEmail('diana.prince@gmail.com')
              ->setPassword($password)
              ->setRoles((array)'ROLE_USER')
              ->setProfilePicture('diana-profile.png')
              ->setCreatedAt(new DateTime())
              ->setIsVerified(1);
        $manager->persist($user3);

        $video1 = new Video();
        $video1
            ->setName("How to Mute Grab on a Snowboard - Goofy")
            ->setUrl("https://www.youtube.com/embed/CflYbNXZU3Q");
        $manager->persist($video1);

        $video2 = new Video();
        $video2
            ->setName("How to Mute Grab on a Snowboard - Regular")
            ->setUrl("https://www.youtube.com/embed/jm19nEvmZgM");
        $manager->persist($video2);

        $video3 = new Video();
        $video3
            ->setName("How to Frontside 360 on a Snowboard")
            ->setUrl("https://www.youtube.com/embed/9T5AWWDxYM4");
        $manager->persist($video3);

        $video4 = new Video();
        $video4
            ->setName("How to Backside 180 on a Snowboard")
            ->setUrl("https://www.youtube.com/embed/zqJLx7vZ7Uk");
        $manager->persist($video4);

        $picture1 = new Picture();
        $picture1
            ->setPath("mute.jpg")
            ->setCaption("Snowboard Tricks : Mute");
        $manager->persist($picture1);

        $picture2 = new Picture();
        $picture2
            ->setPath("frontside-360.jpg")
            ->setCaption("Snowboard Tricks : Frontside 360");
        $manager->persist($picture2);

        $picture3 = new Picture();
        $picture3
            ->setPath("backside-180.jpg")
            ->setCaption("Snowboard Tricks : backside 180");
        $manager->persist($picture3);

        $picture4 = new Picture();
        $picture4
            ->setPath("ollie.jpg")
            ->setCaption("Snowboard Tricks : 0llie");
        $manager->persist($picture4);

        $picture5 = new Picture();
        $picture5
            ->setPath("backflip.jpg")
            ->setCaption("Snowboard Tricks : Backflip");
        $manager->persist($picture5);

        $picture6 = new Picture();
        $picture6
            ->setPath("method-air.jpeg")
            ->setCaption("Snowboard Tricks : Method air");
        $manager->persist($picture6);

        $picture7 = new Picture();
        $picture7
            ->setPath("cork.jpg")
            ->setCaption("Snowboard Tricks : Cork");
        $manager->persist($picture7);

        $picture8 = new Picture();
        $picture8
            ->setPath("mctwist.jpg")
            ->setCaption("Snowboard Tricks : Mc Twist");
        $manager->persist($picture8);

        $picture9 = new Picture();
        $picture9
            ->setPath("tail-grab.jpg")
            ->setCaption("Snowboard Tricks : Tail Grab");
        $manager->persist($picture9);

        $picture10 = new Picture();
        $picture10
            ->setPath("backside-air.png")
            ->setCaption("Snowboard Tricks : Backside Air");
        $manager->persist($picture10);

        $picture11 = new Picture();
        $picture11
            ->setPath("backside-air-2.png")
            ->setCaption("Snowboard Tricks : Backside Air");
        $manager->persist($picture11);

        $picture12 = new Picture();
        $picture12
            ->setPath("mute-2.jpg")
            ->setCaption("Snowboard Tricks : Mute");
        $manager->persist($picture12);

        $picture13 = new Picture();
        $picture13
            ->setPath("mute-3.jpg")
            ->setCaption("Snowboard Tricks : Mute");
        $manager->persist($picture13);

        $category1 = new Category();
        $category1->setName("Grabs");
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName("Rotations");
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName("Straight Airs");
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName("Old School");
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName("Flips");
        $manager->persist($category5);

        $category6 = new Category();
        $category6->setName("Rotations désaxées");
        $manager->persist($category6);

        $category7 = new Category();
        $category7->setName("Autres");
        $manager->persist($category7);

        $trick1 = new Trick();
        $trick1
            ->setName("Mute")
            ->setDescription("La figure Mute n'est jamais une astuce, mais cela vaut vraiment la peine d'essayer car elle corrigera les problèmes de posture mineurs qui découlent d'une conduite légèrement ouverte, améliorant ainsi votre positionnement global de style libre. Une saisie silencieuse est l'endroit où la main avant saisit le bord de l'orteil entre les pieds. La planche est maintenue à plat.
            Commencez directement derrière le kicker à un point qui vous permettra d'atterrir en toute sécurité sur le dessus de la table ou juste au-dessus de l'articulation. Recréez une forme d'entonnoir avec vos virages en vous concentrant sur la conduite droite au centre du kicker.
            Pensez à être sur une base plate lorsque vous remontez le kicker avec le haut du corps aligné avec la planche. Vous avez la possibilité de maintenir cette base plate ou de transférer légèrement la pression sur vos orteils lorsque vous lancez un pop ou un ollie. Vous pouvez monter le kicker légèrement plus bas que la normale pour réduire la distance de déplacement.")
            ->addPicture($picture1)
            ->addPicture($picture12)
            ->addPicture($picture13)
            ->addVideo($video1)
            ->addVideo($video2)
            ->setCategory($category1);
        $manager->persist($trick1);

        $trick2 = new Trick();
        $trick2
            ->setName("Frontside 360")
            ->setDescription("Le 3.6 front ou frontside 3 est un trick intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side… La phase d’approche est similaire à tous les sauts : on arrive les jambes bien fléchies, les épaules dans l’axe de la board, le regard pointé vers le bout du kicker. L’impulsion peut se faire autant à 2 pieds qu’en ollie façon skate. Les petits 3.6 de bord de piste se font quasi obligatoirement en ollie tandis qu'on aura tendance à plus pousser avec les deux pieds sur un kicker de park. Impulsion donc, en lançant la rotation avec la tête et les épaules vers l’avant de la board. Le menton au niveau de l'épaule, le regard juste par dessus l’épaule. Lancer les épaules plus ou moins fort en fonction de la taille du saut. Dès que l'on décolle, on regroupe les jambes. On peut garder les bras ouvert pour contrôler la vitesse de rotation ou grabber si on est plus à l’aise avec le trick. On peut aussi tweaker pour mettre du style ou ralentir la rotation. Pour l’accélérer de nouveau, il suffit de lâcher le grab et se regrouper. On doit apercevoir la réception par dessus son épaule après le premier demi tour. Quand on voit l’endroit ou on pense atterri passer sous l'épaule puis sous la board, il vous faut se regrouper, les épaules dans l’axe de la board et le tout dans l’axe de la réception. Replaquer en regardant bien ses pieds pour être sûr que la rotation s’arrête. Le défaut le plus commun est de regarder devant au moment ou on atterrit, du coup sans en avoir conscience les  épaules ont fait quelques degrés de plus et ça déséquilibre  le landing... Donc réceptionner bien en appui sur les deux pieds, en regardant ses pieds, et ne relever la tête qu’une fois que l'on a bien amorti. 
            Le 3.6 front se fait aussi en switch, c’est alors un cab 3.6. Les deux versions sont toutes les deux très faciles en bord de piste sur des petits sauts. On peut se lancer en 3.6 front sur de plus gros kickers dès que l'on a bien le mouvement et qu'on se sent à l’aise en l’air avec ses repères. Essayer ensuite en switch quand on sait déjà très bien rider en switch… L'important est comme toujours de bien repérer le spot avant de se lancer.")
            ->setCategory($category2)
            ->addPicture($picture2)
            ->addVideo($video3);
        $manager->persist($trick2);

        $trick3 = new Trick();
        $trick3
            ->setName("Backside 180")
            ->setDescription("Pour les néophytes, le backside 180 ou 180 back est un saut avec un demi tour qui s'effectue côté pointes de pieds en envoyant les épaules dos à la pente lors de la rotation, ce qui fait qu'à l’atterrissage on se retrouve en marche arrière. Comme dans toute rotation l’important est la synchronisation entre l’impulsion et la rotation des épaules. La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre frontside ; le regard est pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion. L’impulsion : on a le choix entre un ollie façon skate (comme on peut le voir dans notre tuto sur le Ollie) et une impulsion franche à deux pieds. L’impulsion à deux pieds conviendra mieux sur un kicker de park alors qu’un ollie plus skate et un peu sur la carre est plus évident en bord de piste. Donc on envoie une impulsion  en enclenchant très doucement les épaules de 30°. Engager la rotation à l’aveugle, de dos… pas de panique, l’astuce est de regarder votre pied arrière pour voir défiler le sol en dessous et permettre au corps de faire un 180° progressif. Attendez de voir la réception pour ajuster la board  tout en gardant les épaules dans l’axe de la planche ou légèrement en retard pour bien arrêter la rotation. En réception : bien amortir sur les jambes, continuer de regarder entre les pieds pour garder l’équilibre. Ce n’est qu’une fois que l'on a bien amorti qu'on pourra relever la tête et regarder ou l'on va…")
            ->setCategory($category2)
            ->addPicture($picture3)
            ->addVideo($video4);
        $manager->persist($trick3);

        $trick4 = new Trick();
        $trick4
            ->setName("Ollie")
            ->setDescription("Le Ollie, c'est la base du freestyle en snowboard, et ça rendra beaucoup plus fun même la piste traditionnelle. Le Ollie est une impulsion  avec déformation de la planche qui permet de faire un saut, comme un ollie de skate, mais en beaucoup plus facile car les deux pieds sont attachés sur la board. La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre; le regard pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion. Pour déclencher le Ollie, il faut tirer sur la jambe avant tout en appuyant sur la jambe arrière pour déformer la planche et aller chercher le pop de son snowboard (le «rebond» de la planche). On peut s'aider des bras en les dépliants comme un oiseau qui cherche à s'envoler ;). Dés que l’on sent qu’on décolle, il faut regrouper les jambes et les bras pour gagner en stabilité, le regard cherche déjà l’endroit où on va aller atterrir tout en essayant de profiter du moment présent… Pour atterrir, il faut légèrement détendre les jambes pour aller chercher le sol tout en préparant l’amorti, c’est à dire forcer sur les jambes qui servent d’amortisseur. Bien plier les genoux sans se laisser assoir par la force de gravité. Le mieux c’est de commencer à s’entrainer à faire des ollies à plat sur la piste, puis en profitant des petits reliefs de bord de piste. Quand on se sent vraiment  à l’aise, on peut commencer à essayer sur de plus gros sauts (kickers de snowpark par exemple). Ne pas hésiter à être créatif, repérer toute variation de terrain qui peut être un bon spot pour envoyer un ollie, et transformer la montagne en terrain de jeu…")
            ->setCategory($category3)
            ->addPicture($picture4);
        $manager->persist($trick4);

        $trick5 = new Trick();
        $trick5
            ->setName("Backflip")
            ->setDescription("Le fameux Backflip, un trick très fun et facile à maitriser que l’on peut placer à beaucoup d’endroits.
            On peut aussi l’appeler rodéo back 3.6 si on le tourne un peu sur le côté, mais c’est le même mouvement. Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même. Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement. Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter... Donc impulsion à deux pieds, et on envoie la tête en arrière pour chercher le mouvement. Dès que l’on a décollé il faut remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que l’on est à l’aise avec.Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en arrière. Très vite on peut voir la réception et on va pouvoir gérer la fin de al rotation soit en se tendant un peu pour la ralentir, soit en se regroupant encore davantage pour tourner plus vite. Replacez bien la board sous votre corps avant d’atterrir, et amortir en pliant les jambes")
            ->setCategory($category5)
            ->addPicture($picture5);
        $manager->persist($trick5);

        $trick6 = new Trick();
        $trick6
            ->setName("Method Air")
            ->setDescription("Cette figure qui consiste à attraper sa planche d'une main et le tourner perpendiculairement au sol est un classique old school. Il n'empêche qu'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du air le plus haut en s'élevant à 9,8 mètres au-dessus du kick (sommet d'un mur d'une rampe ou autre structure de saut).")
            ->setCategory($category4)
            ->addPicture($picture6);
        $manager->persist($trick6);

        $trick7 = new Trick();
        $trick7
            ->setName("Cork")
            ->setDescription("Le diminutif de corkscrew qui signifie littéralement tire-bouchon et désignait les premières simples rotations têtes en bas en frontside. Désormais, on utilise le mot cork à toute les sauces pour qualifier les figures où le rider passe la tête en bas, peu importe le sens de rotation. Et dorénavant en compétition, on parle souvent de double cork, triple cork et certains riders vont jusqu'au quadruple cork !")
            ->setCategory($category6)
            ->addPicture($picture7);
        $manager->persist($trick7);

        $trick8 = new Trick();
        $trick8
            ->setName("Mc Twist")
            ->setDescription("Le Mc Twist est un flip (rotation verticale) agrémenté d'une vrille. Un saut plutôt périlleux réservé aux riders les plus confirmés. Le champion Shaun White s'est illustré par un Double Mc Twist 1260 lors de sa session de Half-Pipe aux Jeux Olympiques de Vancouver en 2010.")
            ->setCategory($category6)
            ->addPicture($picture8);
        $manager->persist($trick8);

        $trick9 = new Trick();
        $trick9
            ->setName("Tail Grab")
            ->setDescription("La main arrière saisit la queue du snowboard. [1] Les variations incluent le redressement ou le «désossage» de la jambe avant, ou le «peaufinage» de la planche légèrement à l'avant ou à l'arrière. De préférence, faites-le sur le même saut que vous avez pratiqué dans l'indys, mais tout saut, falaise ou rouleau sur lequel vous pouvez obtenir un bon air fonctionnera. Approchez à nouveau à bonne vitesse. La vitesse est votre amie - elle vous donne plus de temps d'antenne et un bonus supplémentaire d'adrénaline. Note à soi-même: «L'adrénaline peut créer une dépendance!» Rappelez-vous, une planche plate et un bon équilibre centré. Ainsi, vos yeux regardent où vous allez - vers la lèvre du saut, le bord de la falaise ou le sommet du rouleau. Avec votre planche à plat, détachez la queue avec votre jambe arrière. Une fois que vous êtes dans les airs, lancez la prise en ramenant votre main arrière vers la queue de votre planche et en pliant légèrement les genoux. Si vous avez du mal à atteindre cette queue, essayez de plier votre jambe arrière plus que l'avant pour rapprocher la queue de votre planche. Comme l'indy, il vaut mieux penser à votre planche qui vient à la rencontre de votre main plutôt que votre main qui descend - cela vous évitera de vous pencher trop loin et de vous déséquilibrer. Les prises de queue sont si amusantes que vous pouvez les coiffer de nombreuses façons. Comme l'indy, un os du nez est un excellent ajustement à mettre sur un talon. Saisissez votre queue, piquez à nouveau cette jambe avant et tirez sur la queue de votre planche. Des ajustements plus avancés comme celui que je fais ici incluent le tirer latéralement derrière vous et désosser le nez. A environ trois quarts, vous pouvez commencer à lâcher prise. Avec vos yeux repérant l'atterrissage, relâchez la grab et centrez votre poids pour un atterrissage à base plate. Absorber avec vos genoux et idéalement avec les deux pieds atterrissant sur votre planche en même temps. Maintenant, allez-y et amusez-vous.")
            ->setCategory($category1)
            ->addPicture($picture9);
        $manager->persist($trick9);

        $trick10 = new Trick();
        $trick10
            ->setName("Backside Air")
            ->setDescription("Le backside air est probablement le lexique le plus complexe du snowboard. Ironiquement, c'est aussi l'une des plus faciles à faire. Toute personne qui est habituée à tourner et à faire sauter un ollie n'aura aucun problème à sauter, à frapper la main sur le bord du talon et à tirer les jambes, mais pour le faire à grande vitesse, avec hauteur et obtenir cette contorsion intemporelle de positionnement du corps juste ... c'est une chose de beauté. Parce que nous aimons une bonne antenne peaufinée et ajustée par l'arrière peut-être plus que ce qui est strictement sain, nous avons également inclus quelques excellents exemples de méthodes de saut en ligne droite. Bien que techniquement, vous puissiez affirmer qu'ils ne sont pas des airs arrières car il n'y a pas de mur arrière ni de rotation, ce sont des moments de snowboard malades et mémorables enveloppés dans un mouvement corporel similaire et stimulant sur le plan esthétique. De plus, nous entendons toujours comment les gens `` préfèrent voir une grande méthode '' que le pentacorking progressif, alors pardonnez-nous de prendre une liberté et de faire tapis. Certains d'entre eux ont été inclus parce qu'ils se définissent comme des moments eux-mêmes; d'autres pour les personnes qui les ont faites et l'impact qu'elles ont eu sur le snowboard. Quelle que soit la façon dont vous le coupez, les airs de derrière sont de tous les temps et voici quelques-uns des plus grands pour honorer l'histoire du snowboard…")
            ->setCategory($category4)
            ->addPicture($picture10)
            ->addPicture($picture11);
        $manager->persist($trick10);

        $comment = new Comment();
        $comment
            ->setCreatedAt(new DateTime())
            ->setUser($user1)
            ->setTrick($trick1)
            ->setContent('Lorem ipsum dolor sit amet');
        $manager->persist($comment);

        $comment1 = new Comment();
        $comment1
            ->setCreatedAt(new DateTime())
            ->setUser($user3)
            ->setTrick($trick1)
            ->setContent('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2
            ->setCreatedAt(new DateTime())
            ->setUser($user2)
            ->setTrick($trick3)
            ->setContent('Lorem ipsum dolor sit amet');
        $manager->persist($comment2);

        $manager->flush();
    }
}
