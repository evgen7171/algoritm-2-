<?php

class OperationNode
{
    public $first;
    public $middle;
    public $last;

    public function isNull()
    {
        return $this->first || $this->$this->middle || $this->last;
    }
}

class MathOperationTree
{
    public $array;
    public $root;

    public function __construct($str)
    {
        $this->array = $this->handleString($str);
        if (!$this->isValidString($str)) {
            // error of input string
        }
        $this->createTree();
    }

    public function isValidString($str)
    {
        preg_match_all('/[(,),\-,+,*,\/,^,0-9,\.]/', $str, $matches);
        return implode($matches[0]) == $str;
    }

    public function handleString($str)
    {
        preg_match_all('/[0-9]+([\.][0-9]+)?/', $str, $matches_numbers, PREG_OFFSET_CAPTURE);
        preg_match_all('/[(,),\-,+,*,\/,^]/', $str, $matches_symbols, PREG_OFFSET_CAPTURE);
        foreach ($matches_numbers[0] as $item) {
            $numbers[] = [
                'key' => $item[1],
                'item' => $item[0]];
        }
        foreach ($matches_symbols[0] as $item) {
            $symbols[] = [
                'key' => $item[1],
                'item' => $item[0]];
        }
        $arr = array_merge($numbers, $symbols);
        sort($arr);
        return $arr;
    }

    public function createTree()
    {
        $idx = -1;
        $this->root = new OperationNode();
        $this->insertNode($this->root, $idx);
        if ($this->root->middle === null &&
            $this->root->last === null) {
            $this->root = $this->root->first;
        }
    }

    public function insertNode(&$subtree, &$idx)
    {
        $idx++;
        $elem = $this->array[$idx]['item'];
        if ($elem === null) {
            return $subtree;
        }
        if ($subtree === null && !$this->isOperation($elem)) {
            $subtree = new OperationNode();
        }
        if (is_numeric($elem)) {
            if ($subtree->first == null) {
                $subtree->first = $elem;
            } else {
                $subtree->last = $elem;
            }
        }
        if ($this->isOperation($elem)) {
            $subtree->middle = $elem;
        }
        if ($elem == '(') {
            if ($subtree->first == null) {
                $this->insertNode($subtree->first, $idx);
            } else {
                $this->insertNode($subtree->last, $idx);
            }
        }
        if ($elem == ')') {
            $this->findParentNode($this->root, $subtree, $parent);
            $this->insertNode($parent, $idx);
        }
        $this->insertNode($subtree, $idx);
    }

    public function findParentNode(&$tree, OperationNode &$subtree, &$parent)
    {
        if ($tree === null) {
            return false;
        }
        if (
            $tree->first == $subtree ||
            $tree->middle == $subtree ||
            $tree->last == $subtree
        ) {
            $parent = $tree;
        } else {
            if (is_string($tree)) {
                return false;
            }
            $this->findParentNode($tree->first, $subtree, $parent);
            $this->findParentNode($tree->middle, $subtree, $parent);
            $this->findParentNode($tree->last, $subtree, $parent);
        }
    }


    public function getResult()
    {
        $new_tree = clone($this->root);

        do {
            $this->convolTree($new_tree);
        } while (!is_string($new_tree));
        return $new_tree;
    }

    public function convolTree(OperationNode &$subtree)
    {
        if ($subtree === null || is_string($subtree)) {
            return;
        }
        if ($this->isSheet($subtree)) {
            $subtree = $this->solveSheet($subtree);
        } elseif ($bud = $this->isBud($subtree)) {
            $this->convolTree($subtree->{$bud['branch']});
        } else {
            $this->convolTree($subtree->first);
            $this->convolTree($subtree->last);
        }
    }

    public function isOperation($elem)
    {
        return $elem == '+' ||
            $elem == '-' ||
            $elem == '*' ||
            $elem == '/' ||
            $elem == '^';
    }

    public function isBud(OperationNode $node)
    {
        if (is_string($node->first) && !is_string($node->last)) {
            return ['bud' => 'first', 'branch' => 'last'];
        } elseif (!is_string($node->first) && is_string($node->last)) {
            return ['bud' => 'last  ', 'branch' => 'first'];
        }
        return false;
    }

    public function isSheet(OperationNode $node)
    {
        return
            is_string($node->first) &&
            is_string($node->middle) &&
            is_string($node->last);
    }

    public function solveSheet(OperationNode $node)
    {
        if ($node->middle == '^') {
            return (string)eval('return pow((' . $node->first . '),(' . $node->last . '));');
        } elseif ($node->middle == '/' && $node->last == '0') {
            // error dividing by zero
        }
//        if ($node->middle == null && $node->last == null) {
//            return (string)$node->first;
//        }

        return (string)eval('return ' . $node->first . $node->middle . $node->last . ';');
    }
}