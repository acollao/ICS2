try {
                // Start a database transaction
                DB::beginTransaction();
            
                $fieldIndex = "";
                foreach ($filteredData as $index => $innerArray) {
                    echo "Element $index:\n";
                    $fieldIndex = $index;

                    // Loop through the associative array within the outer array
                    foreach ($innerArray as $key => $value) {
                        if($this->checkGarbageCharacter($value)){
                            Log::error("Error occurred while inserting data for Element $index");
                            return response()->json([
                                'status' => 400,
                                'message' => "An error occurred while inserting data. Possible garbage charater found in {$key}.",
                            ]);
                        }
                        $innerArray[$key] = $this->sanitizeFields($key, $value);
                    }
                    
                    // Insert data into the database within the transaction
                    $dbInsert = $connection->table($tblname)->insert($innerArray);
                   
                    if (!$dbInsert) {
                        // Rollback the transaction on failure
                        DB::rollBack();
            
                        Log::error("Error occurred while inserting data for Element $index");
                        return response()->json([
                            'status' => 500,
                            'message' => 'An error occurred while inserting data.',
                        ]);
                    }
                }
                
                
                // Commit the transaction if all insertions were successful
                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                // Handle database query exception
                DB::rollBack();
                
                Log::error("Database query error: {$e->getMessage()}");
                if (str_contains($e->getMessage(), 'too long')) {
                    // Handle the error due to data length
                    return response()->json([
                        'status' => 400,
                        'message' => "Data is too long for one or more fields. {$fieldIndex}",
                    ]);
                } else {
                    // Handle other database query exceptions
                    Log::error("Database query error: {$e->getMessage()}");
                    return response()->json([
                        'status' => 500,
                        'message' => 'An error occurred while inserting data.',
                    ]);
                }
            } catch (\Exception $e) {
                // Handle other exceptions
                DB::rollBack();
            
                Log::error("Error: {$e->getMessage()}");
                return response()->json([
                    'status' => 500,
                    'message' => 'An unexpected error occurred.',
                ]);
            }