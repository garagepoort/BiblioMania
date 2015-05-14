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
    }

    public function test_map_mapsCorrect(){
        $line_values = [50];
        $line_values[LineMapping::FirstAuthorFirstName] = "first_firstName";
        $line_values[LineMapping::FirstAuthorInfix] = "first_infix";
        $line_values[LineMapping::FirstAuthorName] = "first_name";

        $line_values[LineMapping::SecondAuthorFirstName] = "second_firstName";
        $line_values[LineMapping::SecondAuthorInfix] = "second_infix";
        $line_values[LineMapping::SecondAuthorName] = "second_name";

        $line_values[LineMapping::ThirdAuthorFirstName] = "third_firstName";
        $line_values[LineMapping::ThirdAuthorInfix] = "third_infix";
        $line_values[LineMapping::ThirdAuthorName] = "third_name";

        $line_values[LineMapping::AuthorImage] = "author\\some\\image";
        $line_values[LineMapping::AuthorOeuvre] = "oeuvre";

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
        $this->assertEquals($author1->getOeuvre(), $this->bookFromAuthorParameters);
        $this->assertEquals($author1->getImage(), "bookImages/John/image");

        $this->assertEquals($author2->getFirstname(), "second_firstName");
        $this->assertEquals($author2->getInfix(), "second_infix");
        $this->assertEquals($author2->getName(), "second_name");

        $this->assertEquals($author3->getFirstname(), "third_firstName");
        $this->assertEquals($author3->getInfix(), "third_infix");
        $this->assertEquals($author3->getName(), "third_name");
    }

    public function test_mapWhenNoSecondOrThirdAuthor_mapsCorrect(){
        $line_values = [50];
        $line_values[LineMapping::FirstAuthorFirstName] = "first_firstName";
        $line_values[LineMapping::FirstAuthorInfix] = "first_infix";
        $line_values[LineMapping::FirstAuthorName] = "first_name";

        $line_values[LineMapping::SecondAuthorFirstName] = "";
        $line_values[LineMapping::SecondAuthorInfix] = "";
        $line_values[LineMapping::SecondAuthorName] = "";

        $line_values[LineMapping::ThirdAuthorFirstName] = "";
        $line_values[LineMapping::ThirdAuthorInfix] = "";
        $line_values[LineMapping::ThirdAuthorName] = "";

        $line_values[LineMapping::AuthorImage] = "author\\some\\image";
        $line_values[LineMapping::AuthorOeuvre] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(1, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];

        $this->assertEquals("first_firstName", $author1->getFirstname());
        $this->assertEquals("first_infix", $author1->getInfix());
        $this->assertEquals("first_name", $author1->getName());
        $this->assertEquals($this->bookFromAuthorParameters, $author1->getOeuvre());
        $this->assertEquals("bookImages/John/image", $author1->getImage());
    }

    public function test_mapWhenNoImage_mapsCorrect(){
        $line_values = [50];
        $line_values[LineMapping::FirstAuthorFirstName] = "first_firstName";
        $line_values[LineMapping::FirstAuthorInfix] = "first_infix";
        $line_values[LineMapping::FirstAuthorName] = "first_name";

        $line_values[LineMapping::SecondAuthorFirstName] = "";
        $line_values[LineMapping::SecondAuthorInfix] = "";
        $line_values[LineMapping::SecondAuthorName] = "";

        $line_values[LineMapping::ThirdAuthorFirstName] = "";
        $line_values[LineMapping::ThirdAuthorInfix] = "";
        $line_values[LineMapping::ThirdAuthorName] = "";

        $line_values[LineMapping::AuthorImage] = "";
        $line_values[LineMapping::AuthorOeuvre] = "oeuvre";

        $parameters = $this->fileToAuthorParametersMapper->mapToParameters($line_values);

        $this->assertEquals(1, count($parameters));

        /** @var AuthorInfoParameters $author1 */
        $author1 = $parameters[0];

        $this->assertEquals($author1->getImage(), null);
    }

}
