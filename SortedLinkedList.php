// “Implement a library providing SortedLinkedList (linked list that keeps values sorted). It should be able to hold string or int values, but not both. 
Try to think about what you'd expect from such library as a user in terms of usability and best practices, and apply those.”

<?php

class Node {
    public $data;
    public $next;

    public function __construct($data) {
        $this->data = $data;
        $this->next = null;
    }
}

class SortedLinkedList {
    private $head;
    private $dataType;

    public function __construct($dataType = 'int') {
        if ($dataType !== 'int' && $dataType !== 'string') {
            throw new InvalidArgumentException('Invalid data type. Supported types: "int" and "string"');
        }

        $this->head = null;
        $this->dataType = $dataType;
    }

    public function add($data) {
        if ($this->head === null) {
            $this->head = new Node($data);
            return;
        }

        if ($this->dataType === 'int' && !is_int($data)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "int".');
        }

        if ($this->dataType === 'string' && !is_string($data)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "string".');
        }

        if ($this->head->data > $data) {
            $newNode = new Node($data);
            $newNode->next = $this->head;
            $this->head = $newNode;
            return;
        }

        $current = $this->head;
        while ($current->next !== null && $current->next->data < $data) {
            $current = $current->next;
        }

        $newNode = new Node($data);
        $newNode->next = $current->next;
        $current->next = $newNode;
    }

    public function remove($data) {
        if ($this->head === null) {
            return;
        }

        if ($this->dataType === 'int' && !is_int($data)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "int".');
        }

        if ($this->dataType === 'string' && !is_string($data)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "string".');
        }

        if ($this->head->data === $data) {
            $this->head = $this->head->next;
            return;
        }

        $current = $this->head;
        while ($current->next !== null && $current->next->data !== $data) {
            $current = $current->next;
        }

        if ($current->next !== null) {
            $current->next = $current->next->next;
        }
    }

    public function contains($data) {
        $current = $this->head;
        while ($current !== null) {
            if (strcasecmp($current->data, $data) === 0) {
                return true;
            }
            $current = $current->next;
        }
        return false;
    }

    public function size() {
        $count = 0;
        $current = $this->head;
        while ($current !== null) {
            $count++;
            $current = $current->next;
        }
        return $count;
    }

    public function getFirst() {
        return ($this->head !== null) ? $this->head->data : null;
    }

    public function getLast() {
        if ($this->head === null) {
            return null;
        }

        $current = $this->head;
        while ($current->next !== null) {
            $current = $current->next;
        }

        return $current->data;
    }

    public function clear() {
        $this->head = null;
    }

    public function merge(SortedLinkedList $otherList) {
        $mergedList = new SortedLinkedList($this->dataType);
        $current = $this->head;
        while ($current !== null) {
            $mergedList->add($current->data);
            $current = $current->next;
        }

        $current = $otherList->head;
        while ($current !== null) {
            $mergedList->add($current->data);
            $current = $current->next;
        }

        return $mergedList;
    }

    public function display() {
        $current = $this->head;
        while ($current !== null) {
            echo $current->data . " ";
            $current = $current->next;
        }
        echo PHP_EOL;
    }

    public function search($query) {
        if ($this->dataType === 'int' && !is_int($query)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "int" for search query.');
        }

        if ($this->dataType === 'string' && !is_string($query)) {
            throw new InvalidArgumentException('Data type mismatch. Expected "string" for search query.');
        }

        $current = $this->head;
        while ($current !== null) {
            if (strcasecmp($current->data, $query) === 0) {
                return $current->data;
            }
            $current = $current->next;
        }

        return null;
    }
}

// Usage example:
try {
    $sortedList = new SortedLinkedList('string'); // or 'int' for an integer-based SortedLinkedList

    $sortedList->add("apple");
    $sortedList->add("Banana");
    $sortedList->add("Orange");

    $sortedList->display(); // Output: apple Banana Orange

    // Search for an element (case-insensitive)
    $result = $sortedList->search("banana");
    echo "Search Result: " . ($result !== null ? $result : "Not found") . PHP_EOL; // Output: Search Result: Banana

    // You can continue adding elements, and they will be inserted in their proper position
    $sortedList->add("kiwi");
    $sortedList->add("grapes");
    $sortedList->add("Pineapple");

    $sortedList->display(); // Output: apple Banana grapes kiwi Orange Pineapple

    // Search for an element (case-insensitive)
    $result = $sortedList->search("PINEAPPLE");
    echo "Search Result: " . ($result !== null ? $result : "Not found") . PHP_EOL; // Output: Search Result: Pineapple

    // Search for a non-existing element
    $result = $sortedList->search("watermelon");
    echo "Search Result: " . ($result !== null ? $result : "Not found") . PHP_EOL; // Output: Search Result: Not found

} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}



?>