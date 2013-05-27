<?php
/**
 * Date: 2/1/13
 * Class: PDJobPostingFieldTypeManager
 * Description:
 *
 */
class PDUserProfileBehavior extends CBehavior
{
    public function setOwnedBy($user) {
        $this->setBelongsToUser($user);
    }

    public function isOwnedBy($user) {
        return $this->belongsToUser($user);
    }

    public function setBelongsToUser($user) {
        $this->owner->userId = $user->primaryKey;
    }

    public function belongsToUser($user) {
        return $this->owner->userId == $user->primaryKey;
    }

    public function addUserScope($user,$includeNull = false) {
        $userId = is_object($user) && (property_exists($user,'primaryKey') || $user->hasProperty('primaryKey')) ? $user->primaryKey : $user;
        $alias = $this->owner->getTableAlias();
        $this->owner->getDbCriteria()->mergeWith(array(
            'condition'=>"{$alias}.userId=:{$alias}_userId".($includeNull ? " OR {$alias}.userId IS NULL" : ''),
            'params'=>array("{$alias}_userId"=>$userId)
        ));
        return $this->owner;
    }
}
