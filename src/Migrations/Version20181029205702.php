<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181029205702 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, comment_user_id INT NOT NULL, comment_movie_id INT DEFAULT NULL, comment_tv_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9474526C541DB185 (comment_user_id), INDEX IDX_9474526C92D7D5FA (comment_movie_id), INDEX IDX_9474526CB4BECA81 (comment_tv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, original_title VARCHAR(255) NOT NULL, poster_path VARCHAR(255) NOT NULL, original_language VARCHAR(255) NOT NULL, backdrop_path VARCHAR(255) NOT NULL, overview LONGTEXT NOT NULL, release_date VARCHAR(255) NOT NULL, budget INT NOT NULL, runtime INT NOT NULL, status VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, average_note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_genre (movie_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_FD1229648F93B6FC (movie_id), INDEX IDX_FD1229644296D31F (genre_id), PRIMARY KEY(movie_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, note_movie_id INT DEFAULT NULL, note_tv_id INT DEFAULT NULL, note_user_id INT NOT NULL, note INT NOT NULL, INDEX IDX_CFBDFA149FC86A62 (note_movie_id), INDEX IDX_CFBDFA147834F1A7 (note_tv_id), INDEX IDX_CFBDFA1426C8170F (note_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tv (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, poster_path VARCHAR(255) NOT NULL, backdrop_path VARCHAR(255) NOT NULL, average_note INT NOT NULL, overview LONGTEXT NOT NULL, first_air_date VARCHAR(255) NOT NULL, origin_country VARCHAR(255) DEFAULT NULL, original_language VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tv_genre (tv_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_7A2ADBD51D245270 (tv_id), INDEX IDX_7A2ADBD54296D31F (genre_id), PRIMARY KEY(tv_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_movie (user_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_FF9C0937A76ED395 (user_id), INDEX IDX_FF9C09378F93B6FC (movie_id), PRIMARY KEY(user_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tv (user_id INT NOT NULL, tv_id INT NOT NULL, INDEX IDX_ABBBCEC1A76ED395 (user_id), INDEX IDX_ABBBCEC11D245270 (tv_id), PRIMARY KEY(user_id, tv_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C541DB185 FOREIGN KEY (comment_user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C92D7D5FA FOREIGN KEY (comment_movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4BECA81 FOREIGN KEY (comment_tv_id) REFERENCES tv (id)');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149FC86A62 FOREIGN KEY (note_movie_id) REFERENCES movie (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA147834F1A7 FOREIGN KEY (note_tv_id) REFERENCES tv (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1426C8170F FOREIGN KEY (note_user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE tv_genre ADD CONSTRAINT FK_7A2ADBD51D245270 FOREIGN KEY (tv_id) REFERENCES tv (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tv_genre ADD CONSTRAINT FK_7A2ADBD54296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_movie ADD CONSTRAINT FK_FF9C0937A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_movie ADD CONSTRAINT FK_FF9C09378F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tv ADD CONSTRAINT FK_ABBBCEC1A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tv ADD CONSTRAINT FK_ABBBCEC11D245270 FOREIGN KEY (tv_id) REFERENCES tv (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie_genre DROP FOREIGN KEY FK_FD1229644296D31F');
        $this->addSql('ALTER TABLE tv_genre DROP FOREIGN KEY FK_7A2ADBD54296D31F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C92D7D5FA');
        $this->addSql('ALTER TABLE movie_genre DROP FOREIGN KEY FK_FD1229648F93B6FC');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149FC86A62');
        $this->addSql('ALTER TABLE user_movie DROP FOREIGN KEY FK_FF9C09378F93B6FC');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB4BECA81');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA147834F1A7');
        $this->addSql('ALTER TABLE tv_genre DROP FOREIGN KEY FK_7A2ADBD51D245270');
        $this->addSql('ALTER TABLE user_tv DROP FOREIGN KEY FK_ABBBCEC11D245270');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C541DB185');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1426C8170F');
        $this->addSql('ALTER TABLE user_movie DROP FOREIGN KEY FK_FF9C0937A76ED395');
        $this->addSql('ALTER TABLE user_tv DROP FOREIGN KEY FK_ABBBCEC1A76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_genre');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE tv');
        $this->addSql('DROP TABLE tv_genre');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE user_movie');
        $this->addSql('DROP TABLE user_tv');
    }
}
