# LeetCode 9 - Palindrome Number
# https://leetcode.com/problems/palindrome-number/
# Difficulty: Easy

class Solution:
    def isPalindrome(self, x):
        """
        :type x: int
        :rtype: bool
        """
        if x < 0:
            return False
        return str(x) == str(x)[::-1]
