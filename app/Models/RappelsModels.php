<?php

namespace App\Models;

use CodeIgniter\Model;

class RappelsModels extends Model {

    protected $table      = 'rappel';
    protected $primaryKey = 'IDrappel';

    protected $allowedFields = [ 'IDrappel','IDutilisateur','NumClient','DateRappel','HeureRappel','DetailsRappel','bOuvert'    ];

    protected $useTimestamps = false;
    protected $createdField  = 'date_creation';
    protected $updatedField  = 'date_modif';
    
    public function getColumnNames() {
        $db = \Config\Database::connect();
        $query = $db->query("SHOW COLUMNS FROM " . $this->table);
        $columns = $query->getResultArray();

        $columnNames = [];
        foreach ($columns as $column) {
            $columnNames[] = $column['Field'];
        }
        return $columnNames;
    }
 
}
    /*
CREATE TABLE `rappel` (
  `IDrappel` int(11) NOT NULL,
  `IDutilisateur` int(11) NOT NULL,
  `NumClient` int(11) NOT NULL,
  `DateRappel` date NOT NULL,
  `HeureRappel` time NOT NULL,
  `DetailsRappel` text NOT NULL,
  `bOuvert` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `rappel`
--
ALTER TABLE `rappel`
  ADD PRIMARY KEY (`IDrappel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `rappel`
--
ALTER TABLE `rappel`
  MODIFY `IDrappel` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


    */
 
