"use client";
import React, { useEffect, useState } from 'react';
import { useParams, useRouter } from 'next/navigation';
import { motion, AnimatePresence } from 'framer-motion';
import { ArrowLeft, ShoppingCart, Star, Clock, ShieldCheck, Minus, Plus, Check } from 'lucide-react';
import { useCart } from '@/lib/CartContext';
import Link from 'next/link';

export default function ProductDetailPage() {
  const params = useParams();
  const router = useRouter();
  const { addToCart } = useCart();
  const [product, setProduct] = useState<any>(null);
  const [quantity, setQuantity] = useState(1);
  const [loading, setLoading] = useState(true);
  const [added, setAdded] = useState(false);

  useEffect(() => {
    const fetchProduct = async () => {
      try {
        const response = await fetch('/api/products');
        const data = await response.json();
        const found = data.find((p: any) => p.id.toString() === params.id);
        setProduct(found);
      } catch (error) {
        console.error('Error fetching product:', error);
      } finally {
        setLoading(false);
      }
    };
    fetchProduct();
  }, [params.id]);

  const handleAddToCart = () => {
    addToCart({ ...product, quantity });
    setAdded(true);
    setTimeout(() => setAdded(false), 2000);
  };

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center bg-cream-50">
      <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-coffee-900"></div>
    </div>
  );

  if (!product) return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-cream-50 text-coffee-950">
      <h2 className="text-3xl font-black mb-4">Product Not Found</h2>
      <Link href="/menu" className="flex items-center space-x-2 text-coffee-600 font-bold hover:underline">
        <ArrowLeft className="h-5 w-5" />
        <span>Back to Menu</span>
      </Link>
    </div>
  );

  return (
    <div className="max-w-6xl mx-auto py-12 px-6">
      {/* Back Button */}
      <button 
        onClick={() => router.back()}
        className="mb-12 flex items-center space-x-2 text-coffee-400 hover:text-coffee-950 transition-colors font-black uppercase text-xs tracking-widest"
      >
        <ArrowLeft className="h-4 w-4" />
        <span>Back to Collection</span>
      </button>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
        {/* Left: Product Image */}
        <motion.div 
          initial={{ opacity: 0, x: -50 }}
          animate={{ opacity: 1, x: 0 }}
          className="relative group"
        >
          <div className="aspect-square rounded-[3.5rem] overflow-hidden shadow-2xl border-8 border-white">
            <img 
              src={product.image || '/images/default.png'} 
              alt={product.name} 
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
          </div>
          <div className="absolute -bottom-8 -right-8 bg-[#2D1B14] p-8 rounded-full shadow-2xl border-4 border-white animate-bounce-slow">
             <Star className="text-[#D4A373] h-8 w-8 fill-[#D4A373]" />
          </div>
        </motion.div>

        {/* Right: Product Info */}
        <motion.div 
          initial={{ opacity: 0, x: 50 }}
          animate={{ opacity: 1, x: 0 }}
          className="flex flex-col h-full"
        >
          <div className="mb-4">
             <span className="bg-[#D4A373]/10 text-[#D4A373] px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">
               {product.category}
             </span>
          </div>

          <h1 className="text-6xl font-black text-coffee-950 mb-4 leading-tight">{product.name}</h1>
          
          <div className="flex items-center space-x-4 mb-8">
             <div className="flex text-yellow-400">
               {[...Array(5)].map((_, i) => <Star key={i} className="h-5 w-5 fill-current" />)}
             </div>
             <span className="text-coffee-300 font-bold text-sm">(124+ Happy Customer Reviews)</span>
          </div>

          <p className="text-xl text-coffee-500 font-medium leading-relaxed mb-10">
            {product.description || "Our master baristas have carefully selected and roasted these premium beans to provide a rich, bold experience in every cup. Perfect for starting your morning right."}
          </p>

          <div className="text-5xl font-black text-[#C69276] mb-12">
            ₱{Number(product.price).toFixed(2)}
          </div>

          {/* Quantity and Cart */}
          <div className="flex flex-col sm:flex-row items-center gap-6 mt-auto">
             <div className="flex items-center bg-cream-50 border border-coffee-100 rounded-[2rem] p-2 self-stretch sm:self-auto">
                <button 
                  onClick={() => setQuantity(Math.max(1, quantity - 1))}
                  className="p-4 hover:bg-white rounded-full transition-all text-coffee-950"
                >
                  <Minus className="h-6 w-6" />
                </button>
                <span className="w-16 text-center text-xl font-black text-coffee-950">{quantity}</span>
                <button 
                  onClick={() => setQuantity(quantity + 1)}
                  className="p-4 hover:bg-white rounded-full transition-all text-coffee-950"
                >
                  <Plus className="h-6 w-6" />
                </button>
             </div>

             <button 
               onClick={handleAddToCart}
               disabled={added}
               className={`flex-grow py-6 px-12 rounded-[2rem] font-black text-xl flex items-center justify-center space-x-4 transition-all shadow-2xl active:scale-95 group overflow-hidden relative ${
                 added ? 'bg-green-600 text-white' : 'bg-coffee-950 text-white hover:bg-[#D4A373]'
               }`}
             >
               <AnimatePresence mode="wait">
                 {added ? (
                   <motion.div
                     key="check"
                     initial={{ y: 20, opacity: 0 }}
                     animate={{ y: 0, opacity: 1 }}
                     exit={{ y: -20, opacity: 0 }}
                     className="flex items-center space-x-4"
                   >
                     <Check className="h-6 w-6" />
                     <span>Added to Order!</span>
                   </motion.div>
                 ) : (
                   <motion.div
                     key="cart"
                     initial={{ y: 20, opacity: 0 }}
                     animate={{ y: 0, opacity: 1 }}
                     exit={{ y: -20, opacity: 0 }}
                     className="flex items-center space-x-4"
                   >
                     <ShoppingCart className="h-6 w-6 group-hover:rotate-12 transition-transform" />
                     <span>Add to My Order</span>
                   </motion.div>
                 )}
               </AnimatePresence>
             </button>
          </div>

          {/* Features */}
          <div className="grid grid-cols-3 gap-4 mt-12 border-t border-coffee-50 pt-10">
             <div className="flex flex-col items-center text-center space-y-2">
                <div className="bg-cream-50 p-3 rounded-xl"><Clock className="h-5 w-5 text-coffee-400" /></div>
                <span className="text-[10px] font-black uppercase text-coffee-300">Fast Brewing</span>
             </div>
             <div className="flex flex-col items-center text-center space-y-2">
                <div className="bg-cream-50 p-3 rounded-xl"><ShieldCheck className="h-5 w-5 text-coffee-400" /></div>
                <span className="text-[10px] font-black uppercase text-coffee-300">Premium Grade</span>
             </div>
             <div className="flex flex-col items-center text-center space-y-2">
                <div className="bg-cream-50 p-3 rounded-xl"><Star className="h-5 w-5 text-coffee-400" /></div>
                <span className="text-[10px] font-black uppercase text-coffee-300">Best Seller</span>
             </div>
          </div>
        </motion.div>
      </div>
    </div>
  );
}
