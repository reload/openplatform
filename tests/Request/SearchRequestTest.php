<?php

namespace DDB\OpenPlatform\Request;

use DDB\OpenPlatform\OpenPlatform;
use DDB\OpenPlatform\Response\SearchResponse;
use LogicException;
use PHPUnit\Framework\TestCase;

class SearchRequestTest extends TestCase
{
    public function testBasicRequest()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $requestData = [
            'q' => 'harry potter',
            'fields' => ['pid', 'title'],
            'offset' => 2,
            'limit' => 50,
            'sort' => SearchRequest::SORT_TITLE,
            'profile' => 'opac',
        ];
        $op->request('/search', $requestData, SearchResponse::class)->shouldBeCalled();
        $req = new SearchRequest($op->reveal());

        $req->setQuery($requestData['q']);
        $req->setFields($requestData['fields']);
        $req->setOffset($requestData['offset']);
        $req->setLimit($requestData['limit']);
        $req->setSort($requestData['sort']);
        $req->setProfile($requestData['profile']);

        $req->execute();
    }

    public function testQueryRequired()
    {
        $op = $this->prophesize(OpenPlatform::class);
        $this->expectException(LogicException::class);
        $req = new SearchRequest($op->reveal());

        $req->execute();
    }
}
