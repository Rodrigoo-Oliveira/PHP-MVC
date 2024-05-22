<?php

declare(strict_types=1);

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;

class VideoRepository
{
    public function __construct(private \PDO $pdo)
    {
        
    }

    public function add(Video $video)
    {
    $sql = 'INSERT INTO videos (url, title) VALUES (?, ?)';
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(1, $video->url);
    $statement->bindValue(2, $video->title);

    // Executa a instrução SQL e verifica o resultado
    if ($statement->execute()) {
        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));
        return $video;  // Retorna o objeto Video com o ID atualizado
    } else {
        // Lança uma exceção ou retorna um valor indicando a falha
        throw new \Exception("Falha ao inserir o vídeo no banco de dados.");
        // Alternativamente, você pode retornar false ou null, dependendo da sua lógica de aplicação
        // return false;
        }
    }

    public function remove(int $id): bool
    {
    // Prepare a instrução SQL
    $sql = 'DELETE FROM videos WHERE id = ?';
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(1, $id);

    // Executa a instrução SQL e verifica o resultado
    if ($statement->execute()) {
        return true;  // Retorna true se a execução foi bem-sucedida
    } else {
        // Lança uma exceção ou retorna um valor indicando a falha
        throw new \Exception("Falha ao remover o vídeo do banco de dados.");
        // Alternativamente, você pode retornar false
        // return false;
        }
    }

    public function update(Video $video): bool
    {
        $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Falha ao atualizar o vídeo do banco de dados.");
        }
    }

    public function all(): array
    {

        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            function (array $videoData) {
                $video = new Video($videoData['url'], $videoData['title']);
                $video->setId($videoData['id']);

                return $video;
        }, 
        $videoList

        );
    }
}

