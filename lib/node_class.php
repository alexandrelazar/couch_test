<?php

class Node{

	private $size = 1;
	private $key = array();
	private $first;
	private $second;
	private $third;
	private $fourth;
	private $parent;
	private $key_value;

	public function __construct( $key, Node $first = NULL, Node $second = NULL, Node $third = NULL, Node $fourth = NULL, Node $parent = NULL ){
		$this->key = array( $key, 0, 0 );
		$this->first = $first;
		$this->second = $second;
		$this->third = $third;
		$this->fourth = $fourth;
		$this->parent = $parent;
	}

	private function find( $key ){
		for( $i = 0; $i < $this->size )
			if( $this->key[$i] == $key ) return true;
		return false;
	}

	private function swap( $x, $y ){
		$r = $x;
		$x = $y;
		$y = $r;
	}

	private function sort2( $x, $y ) {   
        if( $x > $y ) swap( $x, $y );
    }

	private function sort3( $x, $y, $z ){
		if( $x > $y ) swap( $x, $y );
		if( $x > $z ) swap( $x, $z );
		if( $z > $z ) swap( $y, $z );
	}

	private function sort() {
        if( $this->size == 1 ) return;
        if( $this->size == 2 ) sort2( $this->key[0], $this->key[1] );
        if( $this->size == 3 ) sort3( $this->key[0], $this->key[1], $this->key[2] );
    }

    private function insert_to_node( $k ) {
        $this->key[$this->size] = $k;
        $this->size ++;
        $this->sort();
    }

    private function remove_from_node( $k ) {
        if ( $this->size >= 1 && $this->key[0] == $k ) {
            $this->key[0] = $this->key[1];
            $this->key[1] = $this->key[2];
            $this->size --;
        } else if ( $this->size == 2 && $this->key[1] == $k ) {
            $this->key[1] = $this->key[2];
            $this->size --;
        }
    }

    private function become_node2( $k, Node $first, Node $second ) {
        $this->key[0] = $this->k;
        $this->first = $first;
        $this->second = $second;
        $this->third = NULL;
        $this->fourth = NULL;
        $this->parent = NULL;
        $this->size = 1;
    }

    private function is_leaf() {
        return ( $this->first == NULL ) && ( $this->second == NULL ) && ( $this->third == NULL );
    }

    public function insert( Node $p, $k ) { // вставка ключа k в дерево с корнем p; всегда возвращаем корень дерева, т.к. он может меняться
    	if( !$p ) return new Node( $k ); // если дерево пусто, то создаем первую 2-3-вершину (корень)

    	if ( $p->is_leaf() ) $p->insert_to_node( $k );
    	else if( $k <= $p->key[0]) insert( $p->first, $k );
    	else if( ( $p->size == 1 ) || ( ( $p->size == 2) && $k <= $p->key[1] ) ) insert( $p->second, $k );
    	else insert( $p->third, $k );

    	return split( $p );
	}

	public function split( Node $item ) {
    	if( $item->size < 3 ) return $item;

    	$x = new Node( $item->key[0], $item->first, $item->second, NULL, NULL, $item->parent); // Создаем две новые вершины,
    	$y = new Node( $item->key[2], $item->third, $item->fourth, NULL, NULL, $item->parent);  // которые имеют такого же родителя, как и разделяющийся элемент.
    	if( $x->first )  $x->first->parent = $x;    // Правильно устанавливаем "родителя" "сыновей".
    	if( $x->second ) $x->second->parent = $x;   // После разделения, "родителем" "сыновей" является "дедушка",
    	if( $y->first )  $y->first->parent = $y;    // Поэтому нужно правильно установить указатели.
    	if( $y->second ) $y->second->parent = $y;

    	if( $item->parent ) {
        	$item->parent->insert_to_node( $item->key[1] );

        	if( $item->parent->first == $item ) $item->parent->first = NULL;
        	else if( $item->parent->second == $item ) $item->parent->second = NULL;
        	else if( $item->parent->third == $item) $item->parent->third = NULL;

        	// Дальше происходит своеобразная сортировка ключей при разделении.
        	if( $item->parent->first == NULL ) {
            	$item->parent->fourth = $item->parent->third;
            	$item->parent->third = $item->parent->second;
            	$item->parent->second = $y;
            	$item->parent->first = $x;
        	} else if( $item->parent->second == NULL ) {
         	    $item->parent->fourth = $item->parent->third;
            	$item->parent->third = $y;
            	$item->parent->second = $x;
        	} else {
            	$item->parent->fourth = $y;
            	$item->parent->third = $x;
        	}

        	$tmp = $item->parent;
        	return $tmp;
    	} else {
    	    $x->parent = $item;   // Так как в эту ветку попадает только корень,
    	    $y->parent = $item;   // то мы "родителем" новых вершин делаем разделяющийся элемент.
    	    $item->become_node2( $item->key[1], $x, $y );
    	    return $item;
    	}
	}


}

?>