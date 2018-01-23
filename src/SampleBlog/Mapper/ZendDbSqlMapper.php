<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 26/12/17
 * Time: 2:35 AM
 */

namespace SampleBlog\Mapper;

use SampleBlog\Model\Post;
use SampleBlog\Model\PostInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;


class ZendDbSqlMapper implements PostMapperInterface
{
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @var \SampleBlog\Model\PostInterface
     */
    protected $postPrototype;

    /**
     * @param AdapterInterface $dbAdapter
     */
    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        PostInterface $postPrototype
    )
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
    }


    public function find($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('posts');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->postPrototype);
        }

        throw new \InvalidArgumentException("Blog with given ID:{$id} not found.");
    }

    /**
     * @return array|PostInterface[]
     * @TODO implement pagineter.
     */
    public function findAll($isPaginated)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('posts');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {

            $resultSet = new HydratingResultSet(new ClassMethods(), new Post());
            return $resultSet->initialize($result);

//            $resultSet = new ResultSet();
//            \Zend\Debug\Debug::dump($resultSet->initialize($result));
//            die();
        }

        die("no data");
    }


    public function save($post)
    {
        $sql = new Sql($this->dbAdapter);

        $id = (int)$post->getId();
        if (empty($id)) {
            $insert = $sql->insert('posts');
            $data = array(
                'title' => $post->getTitle(),
                'text' => $post->getText(),
            );
            $insert->values($data);
            $stmt = $sql->prepareStatementForSqlObject($insert);
            $result = $stmt->execute();
        } else {
            $update = $sql->update('posts');
            $update->where(array(
                'id' => $post->getId()
            ));
            $update->set(array(
                'title' => $post->getTitle(),
                'text' => $post->getText(),
            ));
            $stmt = $sql->prepareStatementForSqlObject($update);

            try {
                $result = $stmt->execute();
            } catch (\PDOException $exception) {
                die($exception->getMessage());
            }
        }
    }

    public function delete($id)
    {
        $sql = new Sql($this->dbAdapter);
        if (!empty($id)) {
            $delete = $sql->delete('posts');
            $delete->where(
                array(
                    'id' => $id
                )
            );
            $stmt = $sql->prepareStatementForSqlObject($delete);
            $result = $stmt->execute();
        }
    }

}