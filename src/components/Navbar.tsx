"use client";
import Link from 'next/link';
import { Coffee, ShoppingCart, User, Menu, X, Heart } from 'lucide-react';
import { useState } from 'react';
import { useCart } from '@/lib/CartContext';

export default function Navbar() {
  const [isOpen, setIsOpen] = useState(false);
  const { cart } = useCart();

  return (
    <nav className="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-coffee-100">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-20 items-center">
          {/* Logo */}
          <Link href="/" className="flex items-center space-x-2 group">
            <div className="bg-coffee-600 p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300">
              <Coffee className="h-6 w-6 text-white" />
            </div>
            <span className="text-2xl font-bold text-coffee-900 tracking-tight">NextCafe</span>
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center space-x-8">
            <Link href="/menu" className="text-coffee-800 hover:text-coffee-600 font-medium transition-colors">Menu</Link>
            <Link href="/about" className="text-coffee-800 hover:text-coffee-600 font-medium transition-colors">About</Link>
            <Link href="/contact" className="text-coffee-800 hover:text-coffee-600 font-medium transition-colors">Contact</Link>
          </div>

          {/* Icons */}
          <div className="hidden md:flex items-center space-x-5">
            <Link href="/wishlist" className="p-2 text-coffee-600 hover:bg-coffee-50 rounded-full transition-all">
              <Heart className="h-5 w-5" />
            </Link>
            <Link href="/cart" className="p-2 text-coffee-600 hover:bg-coffee-50 rounded-full transition-all relative">
              <ShoppingCart className="h-5 w-5" />
              {cart.length > 0 && (
                <span className="absolute top-0 right-0 h-4 w-4 bg-coffee-600 text-white text-[10px] flex items-center justify-center rounded-full animate-in zoom-in duration-300">
                  {cart.length}
                </span>
              )}
            </Link>
            <Link href="/login" className="flex items-center space-x-2 bg-coffee-900 text-white px-5 py-2.5 rounded-full hover:bg-coffee-800 transition-all shadow-md hover:shadow-lg">
              <User className="h-4 w-4" />
              <span className="font-medium text-sm">Sign In</span>
            </Link>
          </div>

          {/* Mobile menu button */}
          <div className="md:hidden">
            <button onClick={() => setIsOpen(!isOpen)} className="p-2 text-coffee-600">
              {isOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Nav */}
      {isOpen && (
        <div className="md:hidden bg-white border-b border-coffee-100 animate-in slide-in-from-top duration-300">
          <div className="px-4 pt-2 pb-6 space-y-1">
            <Link href="/menu" className="block px-3 py-4 text-base font-medium text-coffee-800 border-b border-coffee-50">Menu</Link>
            <Link href="/about" className="block px-3 py-4 text-base font-medium text-coffee-800 border-b border-coffee-50">About</Link>
            <Link href="/contact" className="block px-3 py-4 text-base font-medium text-coffee-800 border-b border-coffee-50">Contact</Link>
            <div className="flex items-center space-x-4 pt-4 px-3">
              <Link href="/cart" className="flex items-center space-x-2 text-coffee-600 font-medium">
                <ShoppingCart className="h-5 w-5" />
                <span>Cart ({cart.length})</span>
              </Link>
              <Link href="/login" className="flex items-center space-x-2 text-coffee-600 font-medium">
                <User className="h-5 w-5" />
                <span>Account</span>
              </Link>
            </div>
          </div>
        </div>
      )}
    </nav>
  );
}
