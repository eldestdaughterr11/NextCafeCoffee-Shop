"use client";
import { useCart } from "@/lib/CartContext";
import { Trash2, Plus, Minus, ArrowLeft, ShoppingBag } from "lucide-react";
import Link from "next/link";
import { motion } from "framer-motion";

export default function CartPage() {
  const { cart, removeFromCart, updateQuantity, subtotal } = useCart();

  if (cart.length === 0) {
    return (
      <div className="pt-40 pb-20 px-4">
        <div className="max-w-7xl mx-auto text-center">
          <motion.div 
            initial={{ opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            className="bg-white rounded-[3rem] p-20 shadow-sm border border-coffee-100 max-w-2xl mx-auto"
          >
            <div className="bg-coffee-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8">
              <ShoppingBag className="h-10 w-10 text-coffee-300" />
            </div>
            <h1 className="text-4xl font-bold text-coffee-950 mb-4">Your cart is empty</h1>
            <p className="text-coffee-600 mb-10 text-lg">Looks like you haven't added anything to your cart yet.</p>
            <Link href="/menu" className="inline-flex items-center space-x-2 bg-coffee-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-coffee-800 transition-all shadow-xl">
              <ArrowLeft className="h-5 w-5" />
              <span>Back to Menu</span>
            </Link>
          </motion.div>
        </div>
      </div>
    );
  }

  return (
    <div className="pt-32 pb-20 px-4">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-5xl font-bold text-coffee-950 mb-12">Shopping Cart</h1>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          {/* Items List */}
          <div className="lg:col-span-2 space-y-6">
            {cart.map((item) => (
              <motion.div 
                layout
                key={item.id}
                className="bg-white p-6 rounded-[2rem] shadow-sm border border-coffee-100 flex items-center space-x-6 group"
              >
                <div className="h-24 w-24 rounded-2xl overflow-hidden bg-cream-50 flex-shrink-0">
                  <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                </div>
                
                <div className="flex-grow">
                  <h3 className="text-xl font-bold text-coffee-950">{item.name}</h3>
                  <p className="text-coffee-500 font-medium tracking-wide text-xs uppercase mt-1">Product ID: #{item.id}</p>
                  
                  <div className="flex items-center justify-between mt-4">
                    <div className="flex items-center space-x-4 bg-cream-50 rounded-xl p-1">
                      <button 
                        onClick={() => updateQuantity(item.id, -1)}
                        className="p-2 hover:bg-white rounded-lg transition-colors text-coffee-600"
                      >
                        <Minus className="h-4 w-4" />
                      </button>
                      <span className="font-bold text-coffee-900 w-4 text-center">{item.quantity}</span>
                      <button 
                        onClick={() => updateQuantity(item.id, 1)}
                        className="p-2 hover:bg-white rounded-lg transition-colors text-coffee-600"
                      >
                        <Plus className="h-4 w-4" />
                      </button>
                    </div>
                    <div className="text-xl font-bold text-coffee-900">₱{(item.price * item.quantity).toFixed(2)}</div>
                  </div>
                </div>

                <button 
                  onClick={() => removeFromCart(item.id)}
                  className="p-4 text-coffee-300 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all"
                >
                  <Trash2 className="h-6 w-6" />
                </button>
              </motion.div>
            ))}
          </div>

          {/* Summary */}
          <div className="lg:col-span-1">
            <div className="bg-coffee-950 text-white p-8 rounded-[2.5rem] shadow-2xl sticky top-32">
              <h2 className="text-2xl font-bold mb-8 italic">Order Summary</h2>
              
              <div className="space-y-4 mb-8">
                <div className="flex justify-between text-cream-200">
                  <span>Subtotal</span>
                  <span className="font-bold">₱{subtotal.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-cream-200">
                  <span>Delivery Fee</span>
                  <span className="font-bold">₱45.00</span>
                </div>
                <div className="border-t border-white/10 pt-4 mt-4 flex justify-between text-2xl font-bold">
                  <span>Total</span>
                  <span>₱{(subtotal + 45).toFixed(2)}</span>
                </div>
              </div>

              <Link 
                href="/checkout"
                className="w-full bg-[#D4A373] text-white py-5 rounded-2xl font-black text-center block hover:bg-[#B68A5D] transition-all shadow-2xl active:scale-95"
              >
                CHECKOUT NOW
              </Link>
              
              <p className="text-center text-cream-400 text-xs mt-6">
                All prices include applicable taxes.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
