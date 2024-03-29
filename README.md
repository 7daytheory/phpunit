# PHPUnit Practice

## Method Chaining
<p>Method chaining is a programming technique that allows you to call multiple methods on the same object in a single statement. Instead of calling one method at a time and assigning the result to a variable, you can chain method calls together. This can lead to more concise and readable code.<br>
In PHP, method chaining is often facilitated by designing methods in a way that they return the current object ($this) after performing their operations. This allows you to call another method on the same object without needing to store the object in a variable between method calls.
</p>

### Example: 
<code>
class Example {
    private $value;

    public function setValue($value) {
        $this->value = $value;
        return $this; // Return the current object
    }

    public function multiplyBy($factor) {
        $this->value *= $factor;
        return $this; // Return the current object
    }

    public function getResult() {
        return $this->value;
    }
}

// Example usage with method chaining
$result = (new Example())
    ->setValue(5)
    ->multiplyBy(3)
    ->getResult();

echo $result; // Outputs 15
</code>

# <?php
<h2>USE <?php and not just ?> - it took me so much time of troubleshooting and it doesn't appear on the errors</h2>

## Calling a single test
<code>.vendor/bin/phpunit --filter [test method name]</code> ex : <code>./vendor/bin/phpunit test_no_routes_when_created</code>

## Class Property vs Variable
<p>$this->router = new Router(); vs $router = new Router();</p>
<p>$this : refers to current instance of class while $router is a variable. $this->router is an instance variable (property) of the class, and assigning a new instance of Router to it means you are setting the value of the class property.<br>
$router : This syntax is used outside the context of a class or within a function that is not part of a class. $router is a local variable within the current scope (function, method, or global scope, depending on where it's used). It doesn't have the same visibility as a class property.</p>