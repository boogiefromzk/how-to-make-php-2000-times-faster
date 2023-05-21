
#[no_mangle]
pub extern fn fibonacci(number: i64) -> i64 {
  return match number {
    1 | 2 => 1,
    number => fibonacci(number - 1) + fibonacci(number - 2)
  }
}

#[no_mangle]
pub extern fn fibonacci_loop(repeat: i64, number: i64) -> i64 {
  let mut result = number;
  for _ in 0..repeat {
    result = fibonacci(number);
  }
  return result
}