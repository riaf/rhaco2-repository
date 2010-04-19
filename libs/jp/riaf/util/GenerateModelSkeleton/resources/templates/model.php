import('org.rhaco.storage.db.Dao');
/**
 * {$class_name}
 *
 * @author  Keisuke SATO
 **/

class {$class_name} extends Dao
{
<rt:loop param="properties" var="property">
    protected ${$property};
</rt:loop>
<rt:loop param="properties" var="property">
    static protected $__{$property}__ = '{$property.fm_annotation()}';
</rt:loop>
}

