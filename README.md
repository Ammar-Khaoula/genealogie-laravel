
# Site de Généalogie

Un site interactif pour construire, visualiser et gérer des arbres généalogiques en collaboration avec une communauté.

## Prérequis

- PHP 8.x ou supérieur.
- Composer pour la gestion des dépendances.
- Laravel Framework version 10.x ou supérieur.
- MySQL (ou tout autre SGBD compatible avec Laravel).
- Node.js et npm pour la gestion des actifs front-end.

## Mettez en place la base de données

```bash
  php artisan migrate
``` 

## Lancez le serveur de développement 

```bash
  php artisan serve
``` 

## Exemple de Fichier .env

```bash
APP_NAME=genealogie-laravel
APP_ENV=local
APP_KEY=base64:VotreCleGenerée
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=genealogie
DB_USERNAME=root
DB_PASSWORD=root

``` 

## Partie3: Concevez la structure d'une base de données répondant au problème
- dbdiagram.io


![Untitled](https://github.com/user-attachments/assets/3c97adab-51c9-482d-a702-c7ed4f841e2d)

## Partie3: Décrivez comment les données évolues (insertions, updates) au fil des cas "Propositions de Modifications" et "Validation des Modifications" pour montrer que votre structure répond bien au problème.

### 1. Cas : Propositions de Modifications
Les utilisateurs proposent des modifications à une fiche ou ajoutent une relation familiale. Ces propositions sont enregistrées dans la table modification_proposals.

Exemple : Ajout d'une relation parent-enfant

## - Étape 1 : Insertion
1. L'utilisateur rose03 propose d'ajouter une relation parent-enfant entre Jean PERRET (id 1) et Rose PERRET (id 2).
2. Une entrée est insérée dans la table modification_proposals :

```bash
INSERT INTO modification_proposals (user_id, type, target_id, new_value, status, created_at)
VALUES (3, 'relationship_add', NULL, '{"parent_id":1,"child_id":2}', 'pending', NOW());
``` 

  3. Le target_id est NULL car la relation n'existe pas encore.


## - Étape 2 : Notification
Les utilisateurs concernés (ex. jean01 et d'autres membres de la communauté) sont notifiés pour examiner la proposition.
- Modification d'une fiche

## - Étape 1 : Insertion

1. L'utilisateur rose03 propose de modifier la date de naissance de Jean PERRET (id 1).
2. Une entrée est insérée dans la table modification_proposals :

```bash
INSERT INTO modification_proposals (user_id, type, target_id, old_value, new_value, status, created_at)
VALUES (3, 'person_update', 1, '{"date_of_birth":"1960-01-01"}', '{"date_of_birth":"1959-12-31"}', 'pending', NOW());
``` 

### 2. Cas : Validation des Modifications

Les propositions de modification sont validées ou rejetées par la communauté via un processus de vote.

## - Étape 1 : Vote sur une proposition

- Les utilisateurs votent pour accepter ou rejeter une proposition. Les votes sont enregistrés dans la table votes.

```bash
INSERT INTO votes (user_id, proposal_id, vote, created_at)
VALUES (4, 1, 'accept', NOW()),
       (5, 1, 'accept', NOW()),
       (6, 1, 'reject', NOW());
``` 

## - Étape 2 : Décision
- Une fois qu'au moins 3 votes sont enregistrés (acceptations ou rejets), la proposition est traitée :
     - Si 3 votes sont "accept", la modification est appliquée.
     - Si 3 votes sont "reject", la modification est refusée.

## - Étape 3 : Application de la modification

- Si Acceptée :
1.  Pour un ajout de relation:

```bash
INSERT INTO relationships (created_by, parent_id, child_id, created_at)
VALUES (3, 1, 2, NOW());
``` 

2. Pour une mise à jour de fiche :

```bash
UPDATE people
SET date_of_birth = '1959-12-31', updated_at = NOW()
WHERE id = 1;
``` 
3. La proposition est mise à jour:

```bash
UPDATE modification_proposals
SET status = 'accepted', updated_at = NOW()
WHERE id = 1;
``` 

- Si Refusée  :
1.  La proposition est marquée comme refusée :

```bash
UPDATE modification_proposals
SET status = 'rejected', updated_at = NOW()
WHERE id = 1;
``` 
