<?php

class FileToAuthorParametersMapperTest extends TestCase {
    /** @var  FileToAuthorParametersMapper */
    private $fileToAuthorParametersMapper;
    /** @var  FileToOeuvreParametersMapper */
    private $fileToOeuvreParametersMapper;

    private $bookFromAuthorParameters;

    public function setUp(){
        parent::setUp();
        $this->fileToOeuvreParametersMapper = $this->mock('FileToOeuvreParametersMapper');
        $this->fileToAuthorParametersMapper = App::make('FileToAuthorParametersMapper');

        $user = new User(['username' => 'John']);
        $this->be($user);

        $this->bookFromAuthorParameters = array(new BookFromAuthorParameters("some title", 1234));
        $this->fileToOeuvreParametersMapper->shouldReceive('map')->with("oeuvre")->andReturn($this->bookFromAuthorParameters);

        $values = array("Auteur", "Koppelingen");
        LineMapping::initializeMapping($values);
    }

    public function test_map_mapsCorrect(){
        $line_values = [50];
        $line_values[LineMapping::$Authors] = "first_firstName ; second name ; third infix name";

        $line_values[LineMapping::$AuthorImage] = "author\\some\\image";
        $line_values[LineMapping::$AuthorOeuvre] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(3, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];
        /** @var AuthorInfoParameters $author2 */
        $author2 = $parameters[1];
        /** @var AuthorInfoParameters $author3 */
        $author3 = $parameters[2];

        $this->assertEquals($author1->getFirstname(), "");
        $this->assertEquals($author1->getInfix(), "");
        $this->assertEquals($author1->getName(), "first_firstName");
        $this->assertEquals($author1->getOeuvre(), $this->bookFromAuthorParameters);

        $this->assertEquals($author2->getFirstname(), "second");
        $this->assertEquals($author2->getInfix(), "");
        $this->assertEquals($author2->getName(), "name");

        $this->assertEquals($author3->getFirstname(), "third");
        $this->assertEquals($author3->getInfix(), "infix");
        $this->assertEquals($author3->getName(), "name");
    }

    public function test_mapWhenNoImage_mapsCorrect(){
        $line_values = [50];
        $line_values[LineMapping::$Authors] = "first firstName";

        $line_values[LineMapping::$AuthorImage] = "";
        $line_values[LineMapping::$AuthorOeuvre] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(1, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];

        $this->assertEquals($author1->getImage(), null);
    }

}
