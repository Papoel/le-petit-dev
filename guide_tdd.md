# TDD - Le Petit Dev

## Les règles du TDD

Le TDD est un processus qui permet de développer un logiciel en respectant les principes de la programmation orientée objet. 
Il est basé sur le principe de la programmation par les tests. 
Il consiste à écrire un test avant d'écrire le code. Le test doit échouer, puis le code est écrit pour que le test passe. 
Enfin, le code est refactorisé pour qu'il soit le plus propre possible.

## Les outils du TDD

### PHPUnit

PHPUnit est un framework de test unitaire écrit en PHP. Il permet de tester les classes et les méthodes d'un projet.

### Mockery

Mockery est un framework de mock pour PHPUnit. Il permet de créer des mocks de classes et de méthodes.

### Faker

Faker est un générateur de données aléatoires. Il permet de générer des données aléatoires pour les tests.

### ApprovalTests

ApprovalTests est un framework de test d'intégration. Il permet de tester les sorties de commandes.


## Les étapes du TDD

### 1. Écrire un test

Le test doit être écrit avant le code. Il doit être le plus simple possible.

### 2. Faire échouer le test

Le test doit échouer. Il ne doit pas passer.

### 3. Écrire le code

Le code doit être le plus simple possible pour que le test passe.

### 4. Refactoriser le code

Le code doit être refactorisé pour qu'il soit le plus propre possible.

## Exemple de TDD

### 1. Écrire un test

Le test doit être écrit avant le code. Il doit être le plus simple possible.

```php
<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(1, 2);
        $this->assertEquals(3, $result);
    }
}
```

### 2. Faire échouer le test

Le test doit échouer. Il ne doit pas passer.

```php
<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(1, 2);
        $this->assertEquals(3, $result);
    }
}
```

### 3. Écrire le code

Le code doit être le plus simple possible pour que le test passe.

```php
<?php

namespace App;

class Calculator
{
    public function add($a, $b)
    {
        return 0;
    }
}
```

### 4. Refactoriser le code

Le code doit être refactorisé pour qu'il soit le plus propre possible.

```php
<?php

namespace App;

class Calculator
{
    public function add($a, $b)
    {
        return $a + $b;
    }
}
```

## D'autres exemples de TDD 

| #   | Exemple de TDD                | Lien vers la page                                                       |
|-----|-------------------------------|-------------------------------------------------------------------------|
| 1   | TDD avec Mockery              | [TDD avec Mockery](./docs/tdd/TDD_Mockery.md)                           |
| 2   | TDD avec Prophecy             | [TDD avec Prophecy](./docs/tdd/TDD_Prophecy.md)                         |
| 3   | TDD avec PHPUnit              | [TDD avec PHPUnit](./docs/tdd/TDD_PHPUnit.md)                           |
| 4   | TDD avec PHPUnit et Mockery   | [TDD avec PHPUnit et Mockery](./docs/tdd/TDD_PHPUnit-Mockery.md)        |
| 5   | TDD avec PHPUnit et Prophecy  | [TDD avec PHPUnit et Prophecy](./docs/tdd/TDD_PHPUnit-Prophecy.md)      |                                                                  |
| 6   | TDD avec PHPUnit Mock Objects | [TDD avec PHPUnit Mock Objects](./docs/tdd/TDD_PHPUnit-Mock_Objects.md) |                                                                  |

## Ma ligne directive

| #   | Je dois faire                | Comment je le fais                        | Difficulté | Fait |
|-----|------------------------------|-------------------------------------------|------------|------|
| 1   | Créez un projet Symfony      | `symfony new le-petit-dev --webapp`       | 0          | ✓    |
| 2   | Créez la page d'accueil      | Mode TDD (route: app_homepage, url: '/' ) | 2          | ✓    |
| 3   | Attendu de la page d'accueil | [HomePage](./docs/app/homepage.md)        | 5          | ☕️   |
| 4   | Création de la DB            |                                           | 2          | ☕️   |


5. Créez les entités nécessaires Post, Comment, User, Category, Tag, Thumbnail 

6. Écrire les tests pour les entités, en utilisant des assertions pour vérifier que les propriétés sont définies et 
que les méthodes renvoient les résultats attendus, les contraintes de validation doivent être testées.

7. Écrire le code des entités pour que les tests passent.

8. Configurer la base de données en utilisant Doctrine pour stocker les données.

9. Création des controllers nécessaires, commencer par:
   - Controller de la page d'accueil
     - Route: app_homepage
     - Url: /
     - Template: homepage.html.twig
     - Méthode: index => renvoie la vue de la page d'accueil
     - Méthode: banner => renvoie la vue d'un banner customisable via l'admin

  - Controller pour les articles
    - Route: app_posts
    - Url: /posts
    - Template: posts.html.twig
    - Méthode: index => renvoie tous les articles publiés du plus récent au plus ancien
    - Méthode: show => renvoie un article en fonction de son slug + les commentaires associés
    - Méthode: create => renvoie le formulaire de création d'un article
    - Méthode: edit => renvoie le formulaire d'édition d'un article
    - Méthode: update => met à jour un article en base de données
    - Méthode: delete => supprime un article en base de données

  - Controller pour la recherche d'articles
    - Route: app_search
    - Url: /search
    - Template: search.html.twig
    - Méthode: search => renvoie les articles correspondant à la recherche

  - Controller pour les utilisateurs

  - Controller pour les catégories

  - Controller pour les tags

  - Controller pour les images

  - Controller pour l'administration

  - Controller pour la connexion

  - Controller pour la déconnexion

  - Controller pour l'inscription

  - Controller pour la page d'erreur 404

  - Controller pour la page d'erreur 500

  - Controller pour les autres pages d'erreurs

10. Écrire les tests pour ces controllers en utilisant des requêtes HTTP pour vérifier que les réponses renvoyées sont 
correctes.

11. Utilisez des fixtures pour charger des données de test

12. Intégrez des vues Twig pour afficher du Blog dans le navigateur.

13. Écrire des tests pour vérifier que les vues sont correctement rendues et affichent les données attendues.

14. Ajoutez des formulaires pour créer, mettre à jour et supprimer des articles, des commentaires et des utilisateurs.

15. Écrire des tests pour vérifier que les formulaires fonctionnent correctement et que les données sont correctement 
traitées.

16. Ajoutez des fonctionnalités 
    - Pagination, 
    - Recherche, 
    - Recherche par tags, etc. 

17. Faire un github action.
