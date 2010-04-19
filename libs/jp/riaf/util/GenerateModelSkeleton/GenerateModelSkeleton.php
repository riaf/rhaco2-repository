<?php
import('org.rhaco.storage.db.Dao');
module('model.ModelProperty');

class GenerateModelSkeleton extends Flow
{
    static private $anons = array('type', 'require', 'size', 'max', 'min', 'primary', 'unique');
    static private $defaults = array(
        'type' => 'string',
        'require' => 'false',
        'primary' => 'false',
    );

    /**
     * 既存のDBからモデルファイルを自動生成する
     **/
    static public function __setup_generate_model__(Request $request, $value) {
        if (!$request->is_vars('tables')) {
            throw new RuntimeException('tables required');
        }
        $model_path = $request->is_vars('model_path')? $request->in_vars('model_path'): path('libs/model');
        $tables = $request->in_vars('tables');
        $tables = strpos(',', $tables) === false ? array($tables): explode(',', $tables);
        foreach ($tables as $table) {
            $dao = Dao::instant($table, $value);
            $props = $dao->get_columns();
            $properties = array();
            foreach ($props as $prop_name) {
                $property = new ModelProperty();
                $property->name($prop_name);
                foreach (self::$anons as $a) {
                    $anon = $dao->a($prop_name, $a);
                    if (isset(self::$defaults[$prop_name]) && self::$defaults[$prop_name] == $anon) continue;
                    if (!is_null($anon)) $property->annotation($a, $anon);
                }
                $properties[] = $property;
            }
            $class_name = preg_replace('/_(.)/e', 'ucfirst("\\1")', ucfirst(strtolower($table)));
            $template = new Template();
            $template->vars('properties', $properties);
            $template->vars('class_name', $class_name);
            $filename = File::path($model_path, $class_name. '.php');
            $src = "<?php\n". $template->read(module_templates('model.php'));
            File::write($filename, $src);

            // unset
            $dao = $template = $properties = $property = null;
            unset($dao); unset($template); unset($properties); unset($property);
        }
    }
}

