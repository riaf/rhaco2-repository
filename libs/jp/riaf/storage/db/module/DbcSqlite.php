<?php
import('org.rhaco.storage.db.module.DbcModule');
/**
 * SQLite ドライバ
 *
 * @author  Keisuke SATO <riafweb@gmail.com>
 * @license New BSD License
 */
class DbcSqlite extends DbcModule
{
    public function connect($name, $host, $port, $user, $password){
        return new PDO(sprintf('sqlite:%s', $host));
    }
    public function create_sql(Dao $dao){
        $insert = $vars = array();
        $autoid = null;
        foreach($dao->self_columns() as $column){
            $insert[] = '`'. $column->column(). '`';
            $vars[] = $this->update_value($dao,$column->name());
            if($column->auto()) $autoid = $column->name();
        }
        return Dao::daq(
            'insert into `'. $column->table().
                '`('. implode(',', $insert). ') values ('.
                implode(',', array_fill(0, count($insert), '?')). ');',
            $vars,
            $autoid
        );
	}
    public function create_table($name, array $columns){
        $sql = 'create table `'. $name. "`(\n  ";
        $columndef = array();
        foreach($columns as $name => $type){
            switch($type){
                case 'string': $columndef[] = '`'. $name .'` TEXT'; break;
                case 'text': $columndef[] = '`'. $name .'` BLOB'; break;
                case 'number': $columndef[] = '`'. $name .'` REAL'; break;
                case 'serial': $columndef[] = '`'. $name .'` INTEGER PRIMARY KEY'; break;
                case 'boolean': $columndef[] = '`'. $name .'` INTEGER'; break;
                case 'timestamp': $columndef[] = '`'. $name .'` INTEGER'; break;
                case 'date': $columndef[] = '`'. $name .'` BLOB'; break;
                case 'time': $columndef[] = '`'. $name .'` INTEGER'; break;
                case 'strdate': $columndef[] = '`'. $name .'` TEXT'; break;
                case 'intdate': $columndef[] = '`'. $name .'` INTEGER'; break;
                case 'email': $columndef[] = '`'. $name .'` TEXT'; break;
                case 'alnum': $columndef[] = '`'. $name .'` BLOB'; break;
                case 'choice': $columndef[] = '`'. $name .'` BLOB'; break;
                default: throw new InvalidArgumentException('undefined type '.$type);
            }
        }
        $sql .= implode(",\n  ",$columndef);
        $sql .= "\n)";
        return Dao::daq($sql);
    }
    public function show_columns_sql(Dao $obj){
        return Dao::daq('PRAGMA table_info(`'. $obj->table(). '`);');
    }
    public function last_insert_id_sql(){
        return Dao::daq('select last_insert_rowid() as last_insert_id;');
    }
    public function parse_columns(PDOStatement $it){
        // 知らぬ存ぜぬ
        throw new Exception('まて');
    }
}
