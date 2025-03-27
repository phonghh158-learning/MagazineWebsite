<?php

    namespace Core;

    use DateTime;
    use Exception;
    use ReflectionClass;

    class Mapper {
        // Chuyển snake_case thành camelCase
        private static function snakeToCamel(string $string): string {
            return lcfirst(str_replace('_', '', ucwords($string, '_')));
        }

        // Chuyển camelCase thành snake_case
        private static function camelToSnake(string $string): string {
            return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $string)), '_');
        }

        // Array Data to Entity
        public static function DataToEntity($entityClass, $data) {
            try {
                if (!is_array($data)) {
                    throw new Exception("Sai kiểu dữ liệu, dữ liệu đầu vào data phải là array.");
                }
                
                $reflection = new ReflectionClass($entityClass); //Ánh xạ class
                $entity = $reflection->newInstanceWithoutConstructor();
        
                foreach ($data as $key => $value) {
                    $property = self::snakeToCamel($key); // Chuyển snake_case → camelCase
                    $setterMethod = "set" . ucfirst($property);
        
                    if ($reflection->hasMethod($setterMethod)) {
                        $method = $reflection->getMethod($setterMethod);
                        $params = $method->getParameters();
        
                        if (!empty($params)) {
                            $paramType = $params[0]->getType();
        
                            if ($paramType && $paramType->getName() == "DateTime" && $value !== null) {
                                $value = new DateTime($value);
                            }
                        }
        
                        $method->invoke($entity, $value);
                    }
                }
        
                return $entity;
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw new Exception($e->getMessage());
            }
        }

        // Entity to Data Array
        public static function EntityToData($entity) {
            try {
                $data = [];
                $reflection = new ReflectionClass($entity);
        
                foreach ($reflection->getProperties() as $property) {
                    $getterMethod = "get" . ucfirst($property->getName());
        
                    if ($reflection->hasMethod($getterMethod)) {
                        $method = $reflection->getMethod($getterMethod);
                        $value = $method->invoke($entity);
        
                        if ($value instanceof DateTime) {
                            $value = $value->format("Y-m-d H:i:s");
                        }
        
                        $column = self::camelToSnake($property->getName());
                        $data[$column] = $value;
                    }   
                }
        
                return $data;
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw new Exception($e->getMessage());

            }
        }
    }

?>