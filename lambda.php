<?php

// ZERO
$_C0 = function($f) {
	return function($x) {
		return $x;
	};
};

// ADD = λM. λN. λf. λx. N f (M f x)
$_ADD = function($M) {
	return function($N) use ($M) {
		return function($f) use ($M, $N) {
			return function($x) use ($M, $N, $f) {
				$_t0 =$M($f);
				$_t0 = $_t($x);

				$_t1 = $N($f);
				return $_t1($_t0);
			};
		};
	};
};

// MULTIPLY = λM. λN. λf. λx. N (M f) x
$_MULTIPLY = function($M) {
	return function($N) use ($M) {
		return function($f) use ($M, $N) {
			return function($x) use ($M, $N, $f) {
				$_t0 = $M($f);
				$_t1 = $N($_t0);
				return $_t1($x);
			};
		};
	};
};

// EXP = λM. λN. N M
$_EXP = function($M) {
	return function($N) use ($M) {
		return $N($M);
	};
};

// SUCC = λN. λf. λx. f (N f x)

$_SUCC = function($N) {
	return function($f) use ($N) {
		return function($x) use ($N, $f) {
			$_t0 = $N($f);
			$_t0 = $_t0($x);
			return $f($_t0);
		};
	};
};

// PRED = λN. λf. λx. N (λg.λh. h (g f)) (λu. x) (λu. u)

$_PRED = function($N) {
	return function($f) {
		return function($x) use ($N, $f) {
			// (λu. u)
			$_uu = function($u) { return $u;};
			// (λu. x)			
			$_ux = function($u) use($x) { return $x;};

			// (λg.λh. h (g f))
			$_gh = function($g) use($f) {
				return function($h) use($f, $g){
					return $h($g($f));
				};
			};

			$_t0 = $N($_gh);
			$_t0 = $_t0($_ux);
			return $_t0($_uu);
		};
	};
};

$_C1 = $_SUCC($_C0);

$_C2 = $_SUCC($_C1);

$_C3 = $_SUCC($_C2);

$_C4 = $_SUCC($_C3);

$_C5 = $_SUCC($_C4);

$_C6 = $_SUCC($_C5);

$_C7 = $_SUCC($_C6);

$_C8 = $_SUCC($_C7);

$_C9 = $_SUCC($_C8);

// SUB = λM. λN. (N pred) M

$_SUB = function($M) {
	return function($N) use($M) {
		$r = $N($pred);
		return $r($M);
	};
};

// TRUE  = λx. λy. x
$_TRUE = function($x) {
	return function($y) use($x) {
		return $x;
	};
};


// FALSE = λx. λy. y
$_FALSE = function($x) {
	return function($y) {
		return $y;
	};
};

// AND = λM. λN. M (N TRUE FALSE) FALSE

$_AND = function($M) use($_TRUE, $_FALSE) {
	return function($N) use($M, $_TRUE, $_FALSE) {
		$_t = $N($_TRUE);
		$_t = $_t($_FALSE);

		$_t = $M($_t);
		return $_t($_FALSE);
	};
};

// OR = λM. λN. M TRUE (N TRUE FALSE)

$_OR = function($M) use ($_TRUE, $_FALSE){
	return function($N) use ($M, $_TRUE, $_FALSE) {
		$_t = $N($_TRUE);
		$_t = $_t($_FALSE);
		$_z = $M($_TRUE);
		return $_z($_t);
	};
};

// NOT = λM. M FALSE TRUE

$_NOT = function($M) use($_FALSE, $_TRUE) {
	$_r = $M($_FALSE);
	return $_r($_TRUE);
};

// XOR = λM. λN. M (N FALSE TRUE) (N TRUE FALSE)

$_XOR = function($M) use ($_TRUE, $_FALSE){
	return function($N) use ($_TRUE, $_FALSE, $_M){
		$_p0 = $N($_FALSE);
		$_p0 = $_p0($_TRUE);

		$_p1 = $N($_TRUE);
		$_p1 = $_p1($_FALSE);

		$_r = $M($_p0);
		return $_r($_p1);
	};
};

// IF-THEN-ELSE = λM. λa. λb. M a b

$_IF_THEN_ELSE = function($M) {
	return function($a) use($M) {
		return function($b) use($M,$a){
			$_r = $M($a);
			return $_r($b);
		};
	};
};

// PAIR = λx.λy.λz.z x y
 
$_PAIR = function($x) {
	return function($y) use($x) {
		return function ($z) use($x,$y){
			$_r = $z($x);
			return $_r($y);
		};
	};
};

// FIRST = λp.p (λx.λy.x)

$_FIRST = function($p) {
	$_f = function($x) {
		return function($y) use($x){
			return $x;
		};
	};

	return $p($_f);
};

// SECOND = λp.p (λx.λy.y)

$_SECOND = function($p) {
	$_f = function($x) {
		return function($y) {
			return $y;
		};
	};

	return $p($_f);	
};

// NIL = PAIR TRUE TRUE

$_hNIL = $_PAIR($_TRUE);
$_NIL = $_hNIL($_TRUE);

// ISNIL = FIRST
$_ISNIL = $_FIRST;

// CONS = λh.λt.pair false (pair h t)

$_CONS = function($h) use($_PAIR, $_FALSE){
	return function($t) use($h, $_PAIR, $_FALSE){
		$_p0 = $_PAIR($h);
		$_p0 = $_p0($t);

		$_t0 = $_PAIR($_FALSE);
		return $_t0($_p0);
	};
};


// HEAD = λz.FIRST (SECOND z)

$_HEAD = function($z) use($_FIRST, $_SECOND) {
	return $_FIRST($_SECOND($z));
};

// TAIL = λz.SECOND (SECOND z)

$_HEAD = function($z) use($_SECOND) {
	return $_SECOND($_SECOND($z));
};

?>