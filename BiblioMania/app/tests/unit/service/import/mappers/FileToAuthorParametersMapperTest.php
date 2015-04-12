<?php

class FileToAuthorParametersMapperTest extends TestCase {
    /** @var  FileToAuthorParametersMapper */
    private $fileToAuthorParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToAuthorParametersMapper = App::make('FileToAuthorParametersMapper');
    }

    public function test_map_mapsCorrect(){
        $line_values = [50];
        $line_values[0] = "first_firstName";
        $line_values[1] = "first_infix";
        $line_values[2] = "first_name";

        $line_values[3] = "second_firstName";
        $line_values[4] = "second_infix";
        $line_values[5] = "second_name";

        $line_values[6] = "third_firstName";
        $line_values[7] = "third_infix";
        $line_values[8] = "third_name";

        $line_values[18] = "image";
        $line_values[46] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(3, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];
        /** @var AuthorInfoParameters $author2 */
        $author2 = $parameters[1];
        /** @var AuthorInfoParameters $author3 */
        $author3 = $parameters[2];

        $this->assertEquals($author1->getFirstname(), "first_firstName");
        $this->assertEquals($author1->getInfix(), "first_infix");
        $this->assertEquals($author1->getName(), "first_name");
        $this->assertEquals($author1->getOeuvre(), "oeuvre");
        $this->assertEquals($author1->getImage(), "image");

        $this->assertEquals($author2->getFirstname(), "second_firstName");
        $this->assertEquals($author2->getInfix(), "second_infix");
        $this->assertEquals($author2->getName(), "second_name");

        $this->assertEquals($author3->getFirstname(), "third_firstName");
        $this->assertEquals($author3->getInfix(), "third_infix");
        $this->assertEquals($author3->getName(), "third_name");
    }

    public function test_mapWhenNoSecondOrThirdAuthor_mapsCorrect(){
        $line_values = [50];
        $line_values[0] = "first_firstName";
        $line_values[1] = "first_infix";
        $line_values[2] = "first_name";
        $line_values[3] = "";
        $line_values[4] = "";
        $line_values[5] = "";
        $line_values[6] = "";
        $line_values[7] = "";
        $line_values[8] = "";

        $line_values[18] = "image";
        $line_values[46] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(1, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];

        $this->assertEquals($author1->getFirstname(), "first_firstName");
        $this->assertEquals($author1->getInfix(), "first_infix");
        $this->assertEquals($author1->getName(), "first_name");
        $this->assertEquals($author1->getOeuvre(), "oeuvre");
        $this->assertEquals($author1->getImage(), "image");
    }

}
