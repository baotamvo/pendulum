<?php
if(!YII_DEBUG) {
    throw new CHttpException(404);
}
class test extends CComponent {
    public $a;
//    public function getA() {
//        return true;
//    }
}
/**
 * Description of FiddleController
 *
 * @author BaoTam Vo
 */
class FiddleController extends PDController {
    public function actionIndex() {
        $lname = 'v';
        $fname = 'b';
        $mapOption = array(
            '*',
            'airlineStatus'=>array(
                '*',
                'formattedName'
            ),
            'user'=>array(
                'userId',
                'fullName'
            ),
            'jobPosting'=>array(
                '*',
                'jobPosition'=>array(
                    '*'
                )
            ),
            'jobInterview'=>array(
                '*'
            ),
            'trainingClass'=>array(
                '*'
            ),
        );
        $criteria = new CDbCriteria();
        $relevanceBinding = new CMap();
        $relevanceQuery = '0';
        // relevancy calculation
        if($fname || $lname) {
            $relevanceQuery = array();
            if($fname) {
                $relevanceQuery[] = <<<SQL
                1.95*(
                CASE
                    WHEN p.fname like :fname1 THEN 3
                    WHEN p.fname like :fname2 THEN 2
                    WHEN p.fname like :fname3 THEN 1
                    when p.fname = :fname4 then 4
                    else 0
                END
                )
                *levenshtein_ratio(p.fname,:fname)
SQL;
                $relevanceBinding->mergeWith(array(
                    ':fname'=>$fname,
                    ':fname1'=>$fname.'%',
                    ':fname2'=>'%'.$fname.'%',
                    ':fname3'=>'%'.$fname,
                    ':fname4'=>$fname,
                ));
            }

            if($lname) {
                $relevanceQuery[] = <<<SQL
                (
                CASE
                    WHEN p.lname like :lname1 THEN 3
                    WHEN p.lname like :lname2 THEN 2
                    WHEN p.lname like :lname3 THEN 1
                    when p.lname = :lname4 then 4
                    else 0
                END
                )
                *levenshtein_ratio(p.lname,:lname)
SQL;

                $relevanceBinding->mergeWith(array(
                    ':lname'=>$lname,
                    ':lname1'=>$lname.'%',
                    ':lname2'=>'%'.$lname.'%',
                    ':lname3'=>'%'.$lname,
                    ':lname4'=>$lname,
                ));
            }
            $relevanceQuery = '('.implode(' + ',$relevanceQuery).')';
        }
        $relevanceQuery .= ' as relevance';

        $criteria->mergeWith(array(
            'alias'=>'ja',
            'select'=>array('ja.*'),
            'with'=>array(
                'user'=>array(
                    'select'=>'userId',
                    'with'=>array(
                        'pilot'=>array(
                            'alias'=>'p',
                            'select'=>array('p.fname','p.lname', new CDbExpression($relevanceQuery)),
                            'joinType'=>'inner join',
                        ),
                    ),
                    'joinType'=>'inner join',
                ),
                'jobPosting'=>array(
                    'alias'=>'jp',
                    'with'=>array(
                        'jobPosition',
                        'user'=>array(
                            'alias'=>'jp_u',
                            'select'=>false,
                            'joinType'=>'inner join',
                            'condition'=>'jp_u.userId = :jobPostingUserId',
                        ),
                    ),
                    'joinType'=>'inner join'
                ),
                'airlineStatus',
                'jobInterview',
                'trainingClass'
            ),
            'together'=>true,
            'order'=>'relevance desc, ja.timecreated desc',
            'params'=>array(
                ':jobPostingUserId'=>67
            ),
        ));


        $resource = app()->load('jobPosting/models/jobApplication/resource');
        $count $resource->count($criteria);

        $criteria->mergeWith(array(
            'limit'=>10,
            'params'=>$relevanceBinding->toArray()
        ));
        $jobApps = $resource->findAll($criteria);

        echo json_encode(app()->load('service/responseMapper')->map($jobApps,$mapOption));

    }

    protected function process() {

        $lname = $this->lastName;
        $fname = $this->firstName;

        // available columns
        $columns = array('ja.*','p.fname','p.lname');

        // order clause
        $orderClause    = array();


        // building where clause
        $whereClause = '';
//        if($fname || $lname) {
//            $whereClause = array();
//            if($fname) $whereClause[] = ' p.fname like :fname_like ';
//            if($lname) $whereClause[] = ' p.lname like :lname_like ';
//
//            $whereClause = 'where '.implode(' or ',$whereClause);
//        }

        // building relevance query
        $relevanceQuery = '';
        if($fname || $lname) {
            $relevanceQuery = array();

            // relevancy calculation
            if($fname) $relevanceQuery[] = <<<SQL
                1.95*(
                CASE
                    WHEN fname like :fname1 THEN 3
                    WHEN fname like :fname2 THEN 2
                    WHEN fname like :fname3 THEN 1
                    when fname = :fname4 then 4
                    else 0
                END
                )
                *levenshtein_ratio(fname,:fname)
SQL;
            if($lname) $relevanceQuery[] = <<<SQL
                (
                CASE
                    WHEN lname like :lname1 THEN 3
                    WHEN lname like :lname2 THEN 2
                    WHEN lname like :lname3 THEN 1
                    when lname = :lname4 then 4
                    else 0
                END
                )
                *levenshtein_ratio(lname,:lname)
SQL;


            $relevanceQuery = implode(' + ',$relevanceQuery).' relevance';
            $columns[]      = $relevanceQuery;
            $orderClause[]  = 'relevance desc';
        }

        // build binding
        $binding = new CMap;
        if($fname || $lname) {
            if($fname)
                $binding->mergeWith(array(
                    ':fname'=>$fname,
                    ':fname1'=>$fname.'%',
                    ':fname2'=>'%'.$fname.'%',
                    ':fname3'=>'%'.$fname,
                    ':fname4'=>$fname,
                ));
            if($lname)
                $binding->mergeWith(array(
                    ':lname'=>$lname,
                    ':lname1'=>$lname.'%',
                    ':lname2'=>'%'.$lname.'%',
                    ':lname3'=>'%'.$lname,
                    ':lname4'=>$lname,
                ));
        }

        // sort by job app time created
        $orderClause[] = 'ja.timecreated desc';
        $orderClause = 'ORDER BY '.implode(',',$orderClause);

        // add jobposting user filter
        $whereClause = 'where jp_u.userId = :jobPostingUserId ';
        $binding->mergeWith(array(
            ':jobPostingUserId'=>$this->user->userId
        ));

        $columns = implode(',',$columns);
        $sql = <<<SQL
        select {$columns} from pilotjobapplications ja
            inner join users u
            inner join pilots p
            inner join airlinejobpostings jp
            inner join users jp_u
            on ja.userId = u.userId
            and p.userId = u.userId
            and ja.airlinejobpostingId = jp.airlinejobpostingId
            and jp.userId = jp_u.userId
            {$whereClause}
            {$orderClause}
SQL;

        //query for total count
        $countSql = 'select count(*) from ('.$sql.') result_set';
        $this->count = $this->resource->countBySql($countSql,$binding);

        //query for items
        if($this->limit)  $sql .= ' limit '.$this->limit;
        if($this->offset) $sql .= ' offset '.$this->offset;
        $this->items = $this->resource->findAllBySql($sql,$binding);

        return true;
    }
}

?>
