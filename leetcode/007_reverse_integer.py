# LeetCode 7 - Reverse Integer | Medium | O(log x) Time | O(log x) Space
class Solution(object):
    def reverse(self, x):
        sign = -1 if x < 0 else 1
        reversed_num = sign * int(str(abs(x))[::-1])
        if reversed_num < -2**31 or reversed_num > 2**31 - 1:
            return 0
        return reversed_num
