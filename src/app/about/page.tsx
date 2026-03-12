"use client";
import { Coffee, Heart, Users, Award } from "lucide-react";
import { motion } from "framer-motion";

export default function AboutPage() {
  const values = [
    { title: "Quality First", desc: "We source only the top 1% of coffee beans worldwide.", icon: Award },
    { title: "Sustainability", desc: "Our beans are ethically sourced from local farmers.", icon: Heart },
    { title: "Community", desc: "NextCafe is a space for everyone to connect and create.", icon: Users },
  ];

  return (
    <div className="pt-32 pb-20">
      {/* Hero */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-32">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
          <motion.div
            initial={{ opacity: 0, x: -30 }}
            animate={{ opacity: 1, x: 0 }}
          >
            <h1 className="text-6xl font-bold text-coffee-950 mb-8 leading-tight">
              Our Story of <br />
              <span className="text-coffee-600">Passion & Beans</span>
            </h1>
            <p className="text-xl text-coffee-800/80 leading-relaxed mb-8">
              Founded in 2024, NextCafe started with a simple mission: to bring the highest quality coffee experience to our community. Every cup we serve is a result of meticulous roasting and brewing.
            </p>
            <p className="text-lg text-coffee-700/70">
              We believe that coffee is more than just a drink—it's a catalyst for conversation, creativity, and connection.
            </p>
          </motion.div>
          <motion.div
            initial={{ opacity: 0, scale: 0.9 }}
            animate={{ opacity: 1, scale: 1 }}
            className="relative"
          >
            <img 
              src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1000&auto=format&fit=crop" 
              className="rounded-[3rem] shadow-2xl rotate-2"
              alt="Our Cafe"
            />
            <div className="absolute -bottom-10 -left-10 bg-white p-8 rounded-3xl shadow-xl flex items-center space-x-4 max-w-xs">
              <div className="bg-coffee-100 p-3 rounded-2xl">
                <Coffee className="h-6 w-6 text-coffee-600" />
              </div>
              <div className="font-bold text-coffee-900 leading-tight">
                Crafting memories over coffee.
              </div>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Values */}
      <section className="bg-coffee-950 py-32 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-20">
            <h2 className="text-4xl font-bold mb-4">Our Values</h2>
            <div className="w-20 h-1 bg-coffee-500 mx-auto"></div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
            {values.map((v) => (
              <div key={v.title} className="text-center group">
                <div className="bg-white/10 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:bg-coffee-500 transition-all group-hover:-translate-y-2">
                  <v.icon className="h-8 w-8 text-white" />
                </div>
                <h3 className="text-2xl font-bold mb-4">{v.title}</h3>
                <p className="text-cream-300/80 leading-relaxed">{v.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
